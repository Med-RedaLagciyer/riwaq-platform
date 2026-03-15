<?php

namespace App\Controller\Auth;

use App\Service\Auth\RefreshTokenService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class RefreshTokenController extends AbstractController
{
    public function __construct(private RefreshTokenService $refreshTokenService) {}

    #[Route('/api/auth/refresh', name: 'auth_refresh', methods: ['POST'])]
    public function __invoke(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $refreshToken = $data['refresh_token'] ?? null;

        $result = $this->refreshTokenService->refresh($refreshToken, $request);
        return $this->json($result, $result['success'] ? 200 : 401);
    }
}
