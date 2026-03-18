<?php

namespace App\Entity\User;

use App\Entity\Organisation\Organisation;
use App\Entity\User\UserAction;
use App\Repository\User\UserActionPrivilegeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserActionPrivilegeRepository::class)]
#[ORM\Table(name: 'us_011_user_actions')]
#[ORM\UniqueConstraint(columns: ['user_id', 'action_id', 'org_id'])]
class UserActionPrivilege
{
    #[ORM\Id]
    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(name: 'user_id', referencedColumnName: 'id', nullable: false, onDelete: 'CASCADE')]
    private ?User $user = null;

    #[ORM\Id]
    #[ORM\ManyToOne(targetEntity: UserAction::class)]
    #[ORM\JoinColumn(name: 'action_id', referencedColumnName: 'id', nullable: false, onDelete: 'CASCADE')]
    private ?UserAction $action = null;

    #[ORM\Id]
    #[ORM\ManyToOne(targetEntity: Organisation::class)]
    #[ORM\JoinColumn(name: 'org_id', referencedColumnName: 'id', nullable: false, onDelete: 'CASCADE')]
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

    public function getAction(): ?UserAction
    {
        return $this->action;
    }
    public function setAction(?UserAction $action): static
    {
        $this->action = $action;
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
