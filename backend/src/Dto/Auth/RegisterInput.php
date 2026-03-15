<?php

namespace App\Dto\Auth;

use Symfony\Component\Validator\Constraints as Assert;

class RegisterInput
{
    #[Assert\NotBlank(message: 'Email is required.')]
    #[Assert\Email(mode: 'html5', message: 'Please provide a valid email.')]
    public string $email;
}