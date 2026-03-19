<?php

namespace App\Service\User;

use App\Entity\User\User;
use App\Repository\Organisation\OrganisationMemberRepository;

class UserContextService
{
    public function __construct(
        private OrganisationMemberRepository $memberRepository,
    ) {}

    public function getContextsForUser(User $user): array
    {
        $memberships = $this->memberRepository->findByUser($user);

        return array_map(function ($membership) {
            $org = $membership->getOrganisation();

            return [
                'id' => $org->getId(),
                'name' => $org->getName(),
                'type' => $org->getType()->value,
                'logo' => $org->getLogoPath(),
                'member_type' => $membership->getType()->value,
            ];
        }, $memberships);
    }
}