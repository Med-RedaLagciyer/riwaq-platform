<?php

namespace App\Service\Auth;

use App\Dto\Auth\RegisterInput;
use App\Email\Auth\AccountExistsEmail;
use App\Email\Auth\VerificationCodeEmail;
use App\Entity\User\User;
use App\Entity\User\UserProfile;
use App\Entity\User\UserSecurity;
use App\Entity\User\UserStatusLog;
use App\Entity\User\UserToken;
use App\Enum\UserTokenType;
use App\Repository\User\UserRepository;
use App\Repository\User\UserStatusRepository;
use App\Repository\User\UserTokenRepository;
use App\Service\Auth\UserSecurityService;
use Doctrine\ORM\EntityManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\Mailer\MailerInterface;

class RegisterService
{
    public function __construct(
        private EntityManagerInterface $em,
        private UserRepository $userRepository,
        private UserStatusRepository $userStatusRepository,
        private UserTokenRepository $userTokenRepository,
        private MailerInterface $mailer,
        private JWTTokenManagerInterface $jwtManager,
        private UserSecurityService $userSecurityService,
    ) {}

    public function register(RegisterInput $input): array
    {
        $existingUser = $this->userRepository->findOneBy(['email' => $input->email]);

        if ($existingUser) {
            if ($existingUser->getCurrentStatus()->getName() === 'pending_verification') {
                if (!$this->userSecurityService->checkEmailRateLimit($existingUser)) {
                    return ['success' => false, 'message' => 'Too many attempts. Please try again later.'];
                }

                $plainCode = str_pad((string) random_int(0, 999999), 6, '0', STR_PAD_LEFT);
                $hashedCode = hash('sha256', $plainCode);

                $token = new UserToken();
                $token->setUser($existingUser);
                $token->setType(UserTokenType::EMAIL_VERIFICATION);
                $token->setToken($hashedCode);
                $token->setExpiresAt(new \DateTimeImmutable('+15 minutes'));

                $this->em->persist($token);
                $this->em->flush();

                $this->mailer->send(new VerificationCodeEmail($existingUser->getEmail(), $plainCode));
                $this->userSecurityService->recordEmailSent($existingUser);

                return ['success' => true, 'message' => 'check your email'];
            }

            if ($existingUser->getCurrentStatus()->getName() === 'active') {
                if ($existingUser->getPassword() === null) {
                    $temporaryToken = $this->jwtManager->createFromPayload($existingUser, [
                        'scope' => 'complete_registration',
                        'email' => $existingUser->getEmail(),
                    ]);

                    return ['success' => true, 'message' => 'complete_registration', 'temporary_token' => $temporaryToken];
                }

                $this->mailer->send(new AccountExistsEmail($existingUser->getEmail()));
                return ['success' => true, 'message' => 'check your email'];
            }
        }

        $status = $this->userStatusRepository->findOneBy(['name' => 'pending_verification']);

        $user = new User();
        $user->setEmail($input->email);
        $user->setCurrentStatus($status);
        $user->setRoles([]);
        
        $userSecurity = new UserSecurity();
        $userSecurity->setUser($user);

        $userProfile = new UserProfile();
        $userProfile->setUser($user);

        $plainCode = str_pad((string) random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        $hashedCode = hash('sha256', $plainCode);

        $statusLog = new UserStatusLog();
        $statusLog->setUser($user);
        $statusLog->setStatus($status);
        $statusLog->setNotes('Account created via registration');

        $token = new UserToken();
        $token->setUser($user);
        $token->setType(UserTokenType::EMAIL_VERIFICATION);
        $token->setToken($hashedCode);
        $token->setExpiresAt(new \DateTimeImmutable('+15 minutes'));

        $this->em->persist($user);
        $this->em->persist($userSecurity);
        $this->em->persist($userProfile);
        $this->em->persist($statusLog);
        $this->em->persist($token);
        $this->em->flush();

        $this->mailer->send(new VerificationCodeEmail($input->email, $plainCode));
        $this->userSecurityService->recordEmailSent($user);

        return ['success' => true, 'message' => 'check your email'];
    }
}
