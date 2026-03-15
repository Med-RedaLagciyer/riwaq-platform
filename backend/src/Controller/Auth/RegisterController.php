<?php

namespace App\Controller\Auth;

use App\Dto\Auth\RegisterInput;
use App\Service\Auth\RegisterService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

class RegisterController extends AbstractController
{
    public function __construct(private RegisterService $registerService) {}

    #[Route('/api/auth/register', name: 'auth_register', methods: ['POST'])]
    public function __invoke(#[MapRequestPayload] RegisterInput $input): JsonResponse
    {
        $result = $this->registerService->register($input);
        return $this->json($result, $result['success'] ? 200 : 400);
    }
}
