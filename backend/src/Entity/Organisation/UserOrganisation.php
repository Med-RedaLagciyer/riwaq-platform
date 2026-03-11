<?php

namespace App\Entity\Organisation;

use App\Entity\Organisation\Organisation;
use App\Entity\Traits\HasCreatedAt;
use App\Entity\Traits\HasUuidV7;
use App\Entity\User\User;
use App\Repository\Organisation\UserOrganisationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserOrganisationRepository::class)]
#[ORM\Table(name: 'org_002_user_organisations')]
#[ORM\HasLifecycleCallbacks]
class UserOrganisation
{
    use HasUuidV7;
    use HasCreatedAt;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(name: 'user_id', referencedColumnName: 'id', nullable: false)]
    private ?User $user = null;

    #[ORM\ManyToOne(targetEntity: Organisation::class)]
    #[ORM\JoinColumn(name: 'org_id', referencedColumnName: 'id', nullable: false)]
    private ?Organisation $organisation = null;

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
}