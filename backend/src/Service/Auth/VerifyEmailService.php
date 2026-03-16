<?php

namespace App\Service\Auth;

use App\Dto\Auth\VerifyEmailInput;
use App\Entity\User\UserStatusLog;
use App\Enum\UserTokenType;
use App\Repository\User\UserRepository;
use App\Repository\User\UserStatusRepository;
use App\Repository\User\UserTokenRepository;
use Doctrine\ORM\EntityManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;

class VerifyEmailService
{
    public function __construct(
        private EntityManagerInterface $em,
        private UserRepository $userRepository,
        private UserTokenRepository $userTokenRepository,
        private UserStatusRepository $userStatusRepository,
        private JWTTokenManagerInterface $jwtManager,
    ) {}

    public function verify(VerifyEmailInput $input): array
    {
        $user = $this->userRepository->findOneBy(['email' => $input->email]);
        if (!$user) {
            return ['success' => false, 'message' => 'invalid code'];
        }

        // check if token exist
        $token = $this->userTokenRepository->findLatestVerificationToken($user, UserTokenType::EMAIL_VERIFICATION);
        if (!$token) {
            return ['success' => false, 'message' => 'invalid code']; 
        }

        // check if token expired
        if ($token->getExpiresAt() < new \DateTimeImmutable()) {
            return ['success' => false, 'message' => 'code expired'];
        }

        // check if the token = the inputed code
        $hashedInput = hash('sha256', $input->code);
        if (!hash_equals($token->getToken(), $hashedInput)) {
            return ['success' => false, 'message' => 'invalid code']; 
        }

        // mark the token used
        $token->setUsedAt(new \DateTimeImmutable());

        // update the user status to active
        $activeStatus = $this->userStatusRepository->findOneBy(['name' => 'active']);
        $user->setCurrentStatus($activeStatus);

        // create a user status log
        $statusLog = new UserStatusLog();
        $statusLog->setUser($user);
        $statusLog->setStatus($activeStatus);
        $statusLog->setNotes('Email verified');

        $this->em->persist($statusLog);
        $this->em->flush();

        // attach a temporary token for the complete registration process
        $temporaryToken = $this->jwtManager->createFromPayload($user, [
            'scope' => 'complete_registration',
            'email' => $user->getEmail(),
        ]);

        return ['success' => true, 'message' => 'email verified', 'temporary_token' => $temporaryToken];
    }
}
