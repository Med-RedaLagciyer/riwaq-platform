<?php

namespace App\Dto\Auth;

use Symfony\Component\Validator\Constraints as Assert;

class LoginInput
{
    #[Assert\NotBlank(message: 'Email or username is required.')]
    public string $identifier;

    #[Assert\NotBlank(message: 'Password is required.')]
    public string $password;
}