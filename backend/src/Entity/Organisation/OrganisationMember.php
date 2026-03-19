<?php

namespace App\Entity\Organisation;

use App\Entity\Traits\HasCreatedAt;
use App\Entity\Traits\HasUuidV7;
use App\Entity\User\User;
use App\Enum\OrganisationMemberType;
use App\Repository\Organisation\OrganisationMemberRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrganisationMemberRepository::class)]
#[ORM\Table(name: 'org_004_organisation_members')]
#[ORM\UniqueConstraint(columns: ['user_id', 'org_id'])]
#[ORM\HasLifecycleCallbacks]
class OrganisationMember
{
    use HasUuidV7;
    use HasCreatedAt;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(name: 'user_id', referencedColumnName: 'id', nullable: false, onDelete: 'CASCADE')]
    private ?User $user = null;

    #[ORM\ManyToOne(targetEntity: Organisation::class)]
    #[ORM\JoinColumn(name: 'org_id', referencedColumnName: 'id', nullable: false, onDelete: 'CASCADE')]
    private ?Organisation $organisation = null;

    #[ORM\Column(length: 20, enumType: OrganisationMemberType::class)]
    private ?OrganisationMemberType $type = null;

    public function getUser(): ?User
    {
        return $this->user;
    }
    public function setUser(?User $user): static
    {
        $this->user = $user;
        return $this;
    }

    public function getOrganisation(): ?Organisation
    {
        return $this->organisation;
    }
    public function setOrganisation(?Organisation $organisation): static
    {
        $this->organisation = $organisation;
        return $this;
    }

    public function getType(): ?OrganisationMemberType
    {
        return $this->type;
    }
    public function setType(OrganisationMemberType $type): static
    {
        $this->type = $type;
        return $this;
    }
}
