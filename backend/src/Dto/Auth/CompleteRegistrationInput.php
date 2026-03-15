<?php

namespace App\Dto\Auth;

use Symfony\Component\Validator\Constraints as Assert;

class CompleteRegistrationInput
{
    #[Assert\NotBlank(message: 'First name is required.')]
    public string $firstName;

    #[Assert\NotBlank(message: 'Last name is required.')]
    public string $lastName;

    #[Assert\NotBlank(message: 'Username is required.')]
    #[Assert\Length(min: 3, minMessage: 'Username must be at least 3 characters.')]
    #[Assert\Regex(pattern: '/^[a-zA-Z0-9_-]+$/', message: 'Username can only contain letters, numbers, underscores and hyphens.')]
    public string $username;

    #[Assert\NotBlank(message: 'Password is required.')]
    #[Assert\Length(min: 8, minMessage: 'Password must be at least 8 characters.')]
    #[Assert\Regex(pattern: '/[A-Z]/', message: 'Password must contain at least one uppercase letter.')]
    #[Assert\Regex(pattern: '/[a-z]/', message: 'Password must contain at least one lowercase letter.')]
    #[Assert\Regex(pattern: '/[0-9]/', message: 'Password must contain at least one number.')]
    #[Assert\Regex(pattern: '/[^A-Za-z0-9]/', message: 'Password must contain at least one special character.')]
    public string $password;

    #[Assert\NotBlank(message: 'Please confirm your password.')]
    public string $confirmPassword;

    #[Assert\NotBlank(message: 'Temporary token is required.')]
    public string $temporaryToken;
}