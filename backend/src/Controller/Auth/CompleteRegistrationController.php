<?php

namespace App\Controller\Auth;

use App\Dto\Auth\CompleteRegistrationInput;
use App\Service\Auth\CompleteRegistrationService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;

class CompleteRegistrationController extends AbstractController
{
    public function __construct(private CompleteRegistrationService $completeRegistrationService) {}

    #[Route('/api/auth/complete-registration', name: 'auth_complete_registration', methods: ['POST'])]
    public function __invoke(#[MapRequestPayload] CompleteRegistrationInput $input, Request $request): JsonResponse
    {
        $result = $this->completeRegistrationService->complete($input, $request);
        return $this->json($result, $result['success'] ? 200 : 400);
    }
}