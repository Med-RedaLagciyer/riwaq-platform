<?php

namespace App\Entity\Organisation;

use App\Entity\Traits\HasUuidV7;
use App\Repository\Organisation\OrganisationDetailsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrganisationDetailsRepository::class)]
#[ORM\Table(name: 'org_002_organisation_details')]
class OrganisationDetails
{
    use HasUuidV7;

    #[ORM\OneToOne(targetEntity: Organisation::class)]
    #[ORM\JoinColumn(name: 'org_id', referencedColumnName: 'id', nullable: false, onDelete: 'CASCADE')]
    private ?Organisation $organisation = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $address = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $city = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $country = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $postalCode = null;

    #[ORM\Column(length: 30, nullable: true)]
    private ?string $primaryPhone = null;

    #[ORM\Column(length: 30, nullable: true)]
    private ?string $secondaryPhone = null;

    #[ORM\Column(length: 180, nullable: true)]
    private ?string $primaryEmail = null;

    #[ORM\Column(length: 180, nullable: true)]
    private ?string $secondaryEmail = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $website = null;

    public function getOrganisation(): ?Organisation
    {
        return $this->organisation;
    }
    public function setOrganisation(?Organisation $organisation): static
    {
        $this->organisation = $organisation;
        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }
    public function setAddress(?string $address): static
    {
        $this->address = $address;
        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }
    public function setCity(?string $city): static
    {
        $this->city = $city;
        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }
    public function setCountry(?string $country): static
    {
        $this->country = $country;
        return $this;
    }

    public function getPostalCode(): ?string
    {
        return $this->postalCode;
    }
    public function setPostalCode(?string $postalCode): static
    {
        $this->postalCode = $postalCode;
        return $this;
    }

    public function getPrimaryPhone(): ?string
    {
        return $this->primaryPhone;
    }
    public function setPrimaryPhone(?string $primaryPhone): static
    {
        $this->primaryPhone = $primaryPhone;
        return $this;
    }

    public function getSecondaryPhone(): ?string
    {
        return $this->secondaryPhone;
    }
    public function setSecondaryPhone(?string $secondaryPhone): static
    {
        $this->secondaryPhone = $secondaryPhone;
        return $this;
    }

    public function getPrimaryEmail(): ?string
    {
        return $this->primaryEmail;
    }
    public function setPrimaryEmail(?string $primaryEmail): static
    {
        $this->primaryEmail = $primaryEmail;
        return $this;
    }

    public function getSecondaryEmail(): ?string
    {
        return $this->secondaryEmail;
    }
    public function setSecondaryEmail(?string $secondaryEmail): static
    {
        $this->secondaryEmail = $secondaryEmail;
        return $this;
    }

    public function getWebsite(): ?string
    {
        return $this->website;
    }
    public function setWebsite(?string $website): static
    {
        $this->website = $website;
        return $this;
    }
}
