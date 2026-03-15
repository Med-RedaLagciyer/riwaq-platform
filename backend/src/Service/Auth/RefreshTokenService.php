<?php

namespace App\Service\Auth;

use App\Entity\User\User;
use App\Entity\User\UserRefreshToken;
use App\Repository\User\UserRefreshTokenRepository;
use App\Repository\User\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class RefreshTokenService
{
    public function __construct(
        private EntityManagerInterface $em,
        private UserRefreshTokenRepository $userRefreshTokenRepository,
        private UserRepository $userRepository,
        private JWTTokenManagerInterface $jwtManager,
    ) {}

    public function generate(User $user, string $ipAddress, string $userAgent): string
    {
        $token = bin2hex(random_bytes(64));

        $refreshToken = new UserRefreshToken();
        $refreshToken->setUser($user);
        $refreshToken->setToken($token);
        $refreshToken->setExpiresAt(new \DateTimeImmutable('+30 days'));
        $refreshToken->setIpAddress($ipAddress);
        $refreshToken->setUserAgent($userAgent);

        $this->em->persist($refreshToken);
        $this->em->flush();

        return $token;
    }

    public function refresh(string $token, Request $request): array
    {
        if (!$token) {
            return ['success' => false, 'message' => 'Unauthorized'];
        }

        $refreshToken = $this->userRefreshTokenRepository->findOneBy(['token' => $token]);

        if (!$refreshToken) {
            return ['success' => false, 'message' => 'Invalid refresh token'];
        }

        if ($refreshToken->getRevokedAt() !== null) {
            return ['success' => false, 'message' => 'Refresh token has been revoked'];
        }

        if ($refreshToken->getExpiresAt() < new \DateTimeImmutable()) {
            return ['success' => false, 'message' => 'Refresh token has expired'];
        }

        $user = $refreshToken->getUser();
        $newJwt = $this->jwtManager->create($user);
        $newRefreshToken = $this->generate($user, $request->getClientIp(), $request->headers->get('User-Agent', ''));

        $refreshToken->setRevokedAt(new \DateTimeImmutable());
        $this->em->flush();

        return [
            'success' => true,
            'token' => $newJwt,
            'refresh_token' => $newRefreshToken,
        ];
    }
}
