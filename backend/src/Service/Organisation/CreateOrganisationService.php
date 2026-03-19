<?php

namespace App\Service\Organisation;

use App\Dto\Organisation\CreateOrganisationInput;
use App\Entity\Organisation\Organisation;
use App\Entity\Organisation\OrganisationDetails;
use App\Entity\Organisation\OrganisationMember;
use App\Entity\User\User;
use App\Enum\OrganisationMemberType;
use App\Enum\OrganisationType;
use App\Repository\Organisation\OrganisationRepository;
use App\Utils\SlugGenerator;
use Doctrine\ORM\EntityManagerInterface;

class CreateOrganisationService
{
    public function __construct(
        private EntityManagerInterface $em,
        private OrganisationRepository $organisationRepository,
    ) {}

    public function create(CreateOrganisationInput $input, User $user): array
    {
        // Check if user already has an org with the same name
        $existing = $this->organisationRepository->findOneBy([
            'name' => $input->name,
            'owner' => $user,
        ]);

        if ($existing) {
            return ['success' => false, 'message' => 'You already have an organisation with this name'];
        }

        // Generate unique slug
        $slug = $this->generateUniqueSlug($input->name);

        // Create organisation
        $org = new Organisation();
        $org->setName($input->name);
        $org->setSlug($slug);
        $org->setType(OrganisationType::from($input->type));
        $org->setDescription($input->description);
        $org->setOwner($user);

        // Create empty details
        $details = new OrganisationDetails();
        $details->setOrganisation($org);

        // Add owner as member
        $member = new OrganisationMember();
        $member->setUser($user);
        $member->setOrganisation($org);
        $member->setType(OrganisationMemberType::OWNER);

        $this->em->persist($org);
        $this->em->persist($details);
        $this->em->persist($member);
        $this->em->flush();

        return [
            'success' => true,
            'message' => 'Organisation created successfully',
            'organisation' => [
                'id' => $org->getId(),
                'name' => $org->getName(),
                'slug' => $org->getSlug(),
                'type' => $org->getType()->value,
                'logo' => $org->getLogoPath(),
                'member_type' => OrganisationMemberType::OWNER->value,
            ],
        ];
    }

    private function generateUniqueSlug(string $name): string
    {
        $baseSlug = SlugGenerator::generate($name);
        $slug = $baseSlug;
        $counter = 2;

        while ($this->organisationRepository->findOneBy(['slug' => $slug])) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }
}