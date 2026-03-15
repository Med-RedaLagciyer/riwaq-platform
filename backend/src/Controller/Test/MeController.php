<?php

namespace App\Controller\Test;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_USER')]
#[Route('/api/me', name: 'me', methods: ['GET'])]
class MeController extends AbstractController
{
    public function __invoke(): JsonResponse
    {
        return $this->json([
            'user' => $this->getUser()->getUserIdentifier(),
        ]);
    }
}