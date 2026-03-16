<?php

namespace App\Service\Auth;

use App\Dto\Auth\LoginInput;
use App\Entity\User\UserLoginLog;
use App\Repository\User\UserProfileRepository;
use App\Repository\User\UserRepository;
use App\Repository\User\UserSecurityRepository;
use App\Service\Auth\RefreshTokenService;
use App\Service\Auth\UserSecurityService;
use Doctrine\ORM\EntityManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class LoginService
{
    public function __construct(
        private EntityManagerInterface $em,
        private UserRepository $userRepository,
        private UserProfileRepository $userProfileRepository,
        private JWTTokenManagerInterface $jwtManager,
        private UserPasswordHasherInterface $passwordHasher,
        private RefreshTokenService $refreshTokenService,
        private UserSecurityService $userSecurityService,
        private UserSecurityRepository $userSecurityRepository,
    ) {}

    public function login(LoginInput $input, Request $request): array
    {
        $user = $this->userRepository->findOneBy(['email' => $input->identifier])
            ?? $this->userRepository->findOneBy(['username' => $input->identifier]);

        if (!$user) {
            return ['success' => false, 'message' => 'Invalid credentials'];
        }

        $userSecurity = $this->userSecurityRepository->findOneBy(['user' => $user]);

        if ($userSecurity && $userSecurity->getLockedUntil() && $userSecurity->getLockedUntil() > new \DateTimeImmutable()) {
            return ['success' => false, 'message' => 'Account is temporarily locked. Please try again later.'];
        }

        if (!$this->passwordHasher->isPasswordValid($user, $input->password)) {
            $this->userSecurityService->recordFailedLogin($user);
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

        $loginLog = new UserLoginLog();
        $loginLog->setUser($user);
        $loginLog->setIpAddress($request->getClientIp() ?? 'unknown');
        $loginLog->setUserAgent($request->headers->get('User-Agent', ''));
        $loginLog->setIsSuspicious(false);

        $this->em->persist($loginLog);
        $this->em->flush();

        $this->userSecurityService->clearFailedLogins($user);

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
