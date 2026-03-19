<?php

namespace App\Controller\User;

use App\Entity\User\User;
use App\Service\User\UserContextService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

#[Route('/api/me')]
class MeController extends AbstractController
{
    public function __construct(
        private UserContextService $userContextService,
    ) {}

    #[Route('/contexts', name: 'me_contexts', methods: ['GET'])]
    public function getContexts(#[CurrentUser] User $user): JsonResponse
    {
        $contexts = $this->userContextService->getContextsForUser($user);

        return $this->json([
            'success' => true,
            'contexts' => $contexts,
        ]);
    }
}