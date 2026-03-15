<?php

namespace App\Controller\Auth;

use App\Dto\Auth\VerifyEmailInput;
use App\Service\Auth\VerifyEmailService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

class VerifyEmailController extends AbstractController
{
    public function __construct(private VerifyEmailService $verifyEmailService) {}

    #[Route('/api/auth/verify-email', name: 'auth_verify_email', methods: ['POST'])]
    public function __invoke(#[MapRequestPayload] VerifyEmailInput $input): JsonResponse
    {
        $result = $this->verifyEmailService->verify($input);
        return $this->json($result, $result['success'] ? 200 : 400);
    }
}