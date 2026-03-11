<?php

namespace App\Entity\Organisation;

use App\Entity\Traits\HasCreatedAt;
use App\Entity\Traits\HasUpdatedAt;
use App\Entity\Traits\HasUuidV7;
use App\Entity\User\User;
use App\Repository\Organisation\OrganisationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrganisationRepository::class)]
#[ORM\Table(name: 'org_001_organisations')]
#[ORM\HasLifecycleCallbacks]
class Organisation
{
    use HasUuidV7;
    use HasCreatedAt;
    use HasUpdatedAt;

    #[ORM\Column(length: 150)]
    private ?string $name = null;

    #[ORM\Column(length: 150, unique: true)]
    private ?string $slug = null;

    #[ORM\Column]
    private bool $isActive = true;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(name: 'owner_id', referencedColumnName: 'id', nullable: false)]
    private ?User $owner = null;

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): static
    {
        $this->slug = $slug;

        return $this;
    }

    public function isActive(): bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): static
    {
        $this->isActive = $isActive;

        return $this;
    }

    public function getOwner(): ?User
    {
        return $this->owner;
    }

    public function setOwner(?User $owner): static
    {
        $this->owner = $owner;

        return $this;
    }
}