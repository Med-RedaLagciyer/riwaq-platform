<?php

namespace App\Dto\Organisation;

use App\Enum\OrganisationType;
use Symfony\Component\Validator\Constraints as Assert;

class CreateOrganisationInput
{
    #[Assert\NotBlank(message: 'Organisation name is required')]
    #[Assert\Length(min: 2, max: 150, minMessage: 'Name must be at least 2 characters', maxMessage: 'Name cannot exceed 150 characters')]
    public string $name = '';

    #[Assert\NotBlank(message: 'Organisation type is required')]
    #[Assert\Choice(callback: [OrganisationType::class, 'cases'], message: 'Invalid organisation type')]
    public string $type = '';

    #[Assert\Length(max: 1000, maxMessage: 'Description cannot exceed 1000 characters')]
    public ?string $description = null;
}