<?php

namespace App\Entity\User;

use App\Entity\Traits\HasUuidV7;
use App\Entity\User\UserPage;
use App\Repository\User\UserActionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserActionRepository::class)]
#[ORM\Table(name: 'us_010_actions')]
class UserAction
{
    use HasUuidV7;

    #[ORM\ManyToOne(targetEntity: UserPage::class)]
    #[ORM\JoinColumn(name: 'page_id', referencedColumnName: 'id', nullable: false, onDelete: 'CASCADE')]
    private ?UserPage $page = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $className = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $idTag = null;

    #[ORM\Column(length: 100)]
    private ?string $label = null;

    public function getPage(): ?UserPage { return $this->page; }
    public function setPage(?UserPage $page): static { $this->page = $page; return $this; }

    public function getClassName(): ?string { return $this->className; }
    public function setClassName(?string $className): static { $this->className = $className; return $this; }

    public function getIdTag(): ?string { return $this->idTag; }
    public function setIdTag(?string $idTag): static { $this->idTag = $idTag; return $this; }

    public function getLabel(): ?string { return $this->label; }
    public function setLabel(string $label): static { $this->label = $label; return $this; }
}