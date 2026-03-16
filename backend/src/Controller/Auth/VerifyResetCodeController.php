<?php

namespace App\Controller\Auth;

use App\Dto\Auth\VerifyResetCodeInput;
use App\Service\Auth\ForgotPasswordService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

class VerifyResetCodeController extends AbstractController
{
    public function __construct(private ForgotPasswordService $forgotPasswordService) {}

    #[Route('/api/auth/verify-reset-code', name: 'auth_verify_reset_code', methods: ['POST'])]
    public function __invoke(#[MapRequestPayload] VerifyResetCodeInput $input): JsonResponse
    {
        $result = $this->forgotPasswordService->verifyResetCode($input);
        return $this->json($result, $result['success'] ? 200 : 400);
    }
}