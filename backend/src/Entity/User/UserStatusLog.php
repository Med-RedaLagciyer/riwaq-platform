<?php

namespace App\Entity\User;

use App\Entity\Traits\HasCreatedAt;
use App\Entity\Traits\HasUuidV7;
use App\Entity\User\User;
use App\Entity\User\UserStatus;
use App\Repository\User\UserStatusLogRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserStatusLogRepository::class)]
#[ORM\Table(name: 'us_003_user_status_log')]
#[ORM\HasLifecycleCallbacks]
class UserStatusLog
{
    use HasUuidV7;
    use HasCreatedAt;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(name: 'user_id', referencedColumnName: 'id', nullable: false)]
    private ?User $user = null;

    #[ORM\ManyToOne(targetEntity: UserStatus::class)]
    #[ORM\JoinColumn(name: 'status_id', referencedColumnName: 'id', nullable: false)]
    private ?UserStatus $status = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $notes = null;

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getStatus(): ?UserStatus
    {
        return $this->status;
    }

    public function setStatus(?UserStatus $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getNotes(): ?string
    {
        return $this->notes;
    }

    public function setNotes(?string $notes): static
    {
        $this->notes = $notes;

        return $this;
    }
}