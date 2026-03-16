<?php

namespace App\Controller\Auth;

use App\Dto\Auth\ResetPasswordInput;
use App\Service\Auth\ForgotPasswordService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

class ResetPasswordController extends AbstractController
{
    public function __construct(private ForgotPasswordService $forgotPasswordService) {}

    #[Route('/api/auth/reset-password', name: 'auth_reset_password', methods: ['POST'])]
    public function __invoke(#[MapRequestPayload] ResetPasswordInput $input): JsonResponse
    {
        $result = $this->forgotPasswordService->resetPassword($input);
        return $this->json($result, $result['success'] ? 200 : 400);
    }
}