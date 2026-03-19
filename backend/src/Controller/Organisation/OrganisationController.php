<?php

namespace App\Controller\Organisation;

use App\Service\Organisation\UserContextService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use App\Entity\User\User;
use App\Dto\Organisation\CreateOrganisationInput;
use App\Service\Organisation\CreateOrganisationService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/api')]
class OrganisationController extends AbstractController
{
    public function __construct(
        private UserContextService $userContextService,
        private ValidatorInterface $validator,
    ) {}

    #[Route('/me/contexts', name: 'me_contexts', methods: ['GET'])]
    public function getContexts(#[CurrentUser] User $user): JsonResponse
    {
        $contexts = $this->userContextService->getContextsForUser($user);

        return $this->json([
            'success' => true,
            'contexts' => $contexts,
        ]);
    }

    #[Route('/organisations', name: 'create_organisation', methods: ['POST'])]
    public function create(
        Request $request,
        #[CurrentUser] User $user,
        CreateOrganisationService $createOrganisationService,
    ): JsonResponse {
        $input = new CreateOrganisationInput();
        $data = json_decode($request->getContent(), true);

        $input->name = $data['name'] ?? '';
        $input->type = $data['type'] ?? '';
        $input->description = $data['description'] ?? null;

        $errors = $this->validator->validate($input);
        if (count($errors) > 0) {
            return $this->json([
                'success' => false,
                'message' => $errors[0]->getMessage(),
            ], 422);
        }

        $result = $createOrganisationService->create($input, $user);

        return $this->json($result, $result['success'] ? 201 : 400);
    }
}
