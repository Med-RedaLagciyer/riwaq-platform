<?php

namespace App\Service\Auth;

use App\Dto\Auth\CompleteRegistrationInput;
use App\Repository\User\UserProfileRepository;
use App\Repository\User\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use App\Service\Auth\RefreshTokenService;
use Symfony\Component\HttpFoundation\Request;

class CompleteRegistrationService
{
    public function __construct(
        private EntityManagerInterface $em,
        private UserRepository $userRepository,
        private UserProfileRepository $userProfileRepository,
        private JWTTokenManagerInterface $jwtManager,
        private UserPasswordHasherInterface $passwordHasher,
        private RefreshTokenService $refreshTokenService,
    ) {}

    public function complete(CompleteRegistrationInput $input, Request $request): array
    {
        $payload = $this->jwtManager->parse($input->temporaryToken);
        if (!$payload || !isset($payload['scope']) || $payload['scope'] !== 'complete_registration') {
            return ['success' => false, 'message' => 'Invalid or expired token'];
        }

        $user = $this->userRepository->findOneBy(['email' => $payload['email']]);
        if (!$user) {
            return ['success' => false, 'message' => 'User not found'];
        }

        if ($input->password !== $input->confirmPassword) {
            return ['success' => false, 'message' => 'Passwords do not match'];
        }

        $user->setUsername($input->username);
        $user->setPassword($this->passwordHasher->hashPassword($user, $input->password));

        $userProfile = $this->userProfileRepository->findOneBy(['user' => $user]);
        $userProfile->setFirstName($input->firstName);
        $userProfile->setLastName($input->lastName);
        $userProfile->setIsComplete(true);

        $this->em->flush();

        $token = $this->jwtManager->create($user);

        $refreshToken = $this->refreshTokenService->generate(
            $user,
            $request->getClientIp(),
            $request->headers->get('User-Agent', '')
        );

        return [
            'success' => true,
            'message' => 'Registration complete',
            'token' => $token,
            'refresh_token' => $refreshToken,
            'user' => [
                'id' => $user->getId(),
                'email' => $user->getEmail(),
                'username' => $user->getUsername(),
                'firstName' => $userProfile->getFirstName(),
                'lastName' => $userProfile->getLastName(),
            ],
        ];
    }
}
