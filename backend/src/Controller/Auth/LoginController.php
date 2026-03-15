<?php

namespace App\Controller\Auth;

use App\Dto\Auth\LoginInput;
use App\Service\Auth\LoginService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;

class LoginController extends AbstractController
{
    public function __construct(private LoginService $loginService) {}

    #[Route('/api/auth/login', name: 'auth_login', methods: ['POST'])]
    public function __invoke(#[MapRequestPayload] LoginInput $input, Request $request): JsonResponse
    {
        $result = $this->loginService->login($input, $request);
        return $this->json($result, $result['success'] ? 200 : 400);
    }
}