<?php

namespace App\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;

trait HasUpdatedAt
{
    #[ORM\Column]
    private ?\DateTimeImmutable $updatedAt = null;

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    #[ORM\PrePersist]
    #[ORM\PreUpdate]
    public function initializeUpdatedAt(): void
    {
        $this->updatedAt = new \DateTimeImmutable();
    }
}