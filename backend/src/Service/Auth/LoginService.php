<?php

namespace App\Service\Auth;

use App\Dto\Auth\LoginInput;
use App\Repository\User\UserProfileRepository;
use App\Repository\User\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use App\Service\Auth\RefreshTokenService;
use Symfony\Component\HttpFoundation\Request;

class LoginService
{
    public function __construct(
        private UserRepository $userRepository,
        private JWTTokenManagerInterface $jwtManager,
        private UserPasswordHasherInterface $passwordHasher,
        private UserProfileRepository $userProfileRepository,
        private RefreshTokenService $refreshTokenService,
    ) {}

    public function login(LoginInput $input, Request $request): array
    {
        $user = $this->userRepository->findOneBy(['email' => $input->identifier])
            ?? $this->userRepository->findOneBy(['username' => $input->identifier]);

        if (!$user) {
            return ['success' => false, 'message' => 'Invalid credentials'];
        }

        if (!$this->passwordHasher->isPasswordValid($user, $input->password)) {
            return ['success' => false, 'message' => 'Invalid credentials'];
        }

        $status = $user->getCurrentStatus()->getName();

        if ($status === 'pending_verification') {
            return ['success' => false, 'message' => 'Please verify your email first'];
        }

        if ($status === 'suspended') {
            return ['success' => false, 'message' => 'Your account has been suspended'];
        }

        if ($status === 'banned') {
            return ['success' => false, 'message' => 'Your account has been banned'];
        }

        if ($status === 'deleted') {
            return ['success' => false, 'message' => 'Your account has been deleted'];
        }

        $token = $this->jwtManager->create($user);

        $userProfile = $this->userProfileRepository->findOneBy(['user' => $user]);

        $refreshToken = $this->refreshTokenService->generate(
            $user,
            $request->getClientIp(),
            $request->headers->get('User-Agent', '')
        );

        return [
            'success' => true,
            'message' => 'Login successful',
            'token' => $token,
            'refresh_token' => $refreshToken,
            'role' => $user->getRoles(),
            'user' => [
                'id' => $user->getId(),
                'email' => $user->getEmail(),
                'username' => $user->getUsername(),
                'firstName' => $userProfile?->getFirstName(),
                'lastName' => $userProfile?->getLastName(),
            ],
        ];
    }
}
