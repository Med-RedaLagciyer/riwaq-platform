<?php

namespace App\Controller\Auth;

use App\Dto\Auth\ForgotPasswordInput;
use App\Service\Auth\ForgotPasswordService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

class ForgotPasswordController extends AbstractController
{
    public function __construct(private ForgotPasswordService $forgotPasswordService) {}

    #[Route('/api/auth/forgot-password', name: 'auth_forgot_password', methods: ['POST'])]
    public function __invoke(#[MapRequestPayload] ForgotPasswordInput $input): JsonResponse
    {
        $result = $this->forgotPasswordService->sendResetCode($input);
        return $this->json($result, $result['success'] ? 200 : 400);
    }
}