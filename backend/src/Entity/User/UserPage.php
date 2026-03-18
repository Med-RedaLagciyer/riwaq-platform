<?php

namespace App\Entity\User;

use App\Entity\Traits\HasUuidV7;
use App\Repository\User\UserPageRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserPageRepository::class)]
#[ORM\Table(name: 'us_009_pages')]
class UserPage
{
    use HasUuidV7;

    #[ORM\Column(length: 100)]
    private ?string $label = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $path = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $icon = null;

    #[ORM\ManyToOne(targetEntity: self::class)]
    #[ORM\JoinColumn(name: 'parent_id', referencedColumnName: 'id', nullable: true, onDelete: 'SET NULL')]
    private ?self $parent = null;

    #[ORM\Column(name: 'sort_order', type: 'smallint', options: ['default' => 0])]
    private int $order = 0;

    public function getLabel(): ?string
    {
        return $this->label;
    }
    public function setLabel(string $label): static
    {
        $this->label = $label;
        return $this;
    }

    public function getPath(): ?string
    {
        return $this->path;
    }
    public function setPath(?string $path): static
    {
        $this->path = $path;
        return $this;
    }

    public function getIcon(): ?string
    {
        return $this->icon;
    }
    public function setIcon(?string $icon): static
    {
        $this->icon = $icon;
        return $this;
    }

    public function getParent(): ?self
    {
        return $this->parent;
    }
    public function setParent(?self $parent): static
    {
        $this->parent = $parent;
        return $this;
    }

    public function getOrder(): int
    {
        return $this->order;
    }
    public function setOrder(int $order): static
    {
        $this->order = $order;
        return $this;
    }
}
