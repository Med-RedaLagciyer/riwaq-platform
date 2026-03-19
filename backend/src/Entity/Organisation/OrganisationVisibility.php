<?php

namespace App\Entity\Organisation;

use App\Entity\Traits\HasUuidV7;
use App\Enum\OrganisationVisibility as VisibilityEnum;
use App\Enum\OrganisationVisibilityField;
use App\Repository\Organisation\OrganisationVisibilityRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrganisationVisibilityRepository::class)]
#[ORM\Table(name: 'org_003_organisation_visibility')]
#[ORM\UniqueConstraint(columns: ['org_id', 'field'])]
class OrganisationVisibility
{
    use HasUuidV7;

    #[ORM\ManyToOne(targetEntity: Organisation::class)]
    #[ORM\JoinColumn(name: 'org_id', referencedColumnName: 'id', nullable: false, onDelete: 'CASCADE')]
    private ?Organisation $organisation = null;

    #[ORM\Column(length: 50, enumType: OrganisationVisibilityField::class)]
    private ?OrganisationVisibilityField $field = null;

    #[ORM\Column(length: 20, enumType: VisibilityEnum::class)]
    private ?VisibilityEnum $visibility = null;

    public function getOrganisation(): ?Organisation
    {
        return $this->organisation;
    }
    public function setOrganisation(?Organisation $organisation): static
    {
        $this->organisation = $organisation;
        return $this;
    }

    public function getField(): ?OrganisationVisibilityField
    {
        return $this->field;
    }
    public function setField(OrganisationVisibilityField $field): static
    {
        $this->field = $field;
        return $this;
    }

    public function getVisibility(): ?VisibilityEnum
    {
        return $this->visibility;
    }
    public function setVisibility(VisibilityEnum $visibility): static
    {
        $this->visibility = $visibility;
        return $this;
    }
}
