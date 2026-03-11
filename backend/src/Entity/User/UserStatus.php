<?php

namespace App\Entity\User;

use App\Repository\User\UserStatusRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Traits\HasUuidV7;

#[ORM\Entity(repositoryClass: UserStatusRepository::class)]
#[ORM\Table(name: 'us_002_user_status')]
class UserStatus
{
    use HasUuidV7;
    
    #[ORM\Column(length: 50)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }
}
