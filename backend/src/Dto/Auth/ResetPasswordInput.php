<?php

namespace App\Dto\Auth;

use Symfony\Component\Validator\Constraints as Assert;

class ResetPasswordInput
{
    #[Assert\NotBlank(message: 'Token is required.')]
    public string $temporaryToken;

    #[Assert\NotBlank(message: 'Password is required.')]
    #[Assert\Length(min: 8, minMessage: 'Password must be at least 8 characters.')]
    #[Assert\Regex(pattern: '/[A-Z]/', message: 'Password must contain at least one uppercase letter.')]
    #[Assert\Regex(pattern: '/[a-z]/', message: 'Password must contain at least one lowercase letter.')]
    #[Assert\Regex(pattern: '/[0-9]/', message: 'Password must contain at least one number.')]
    #[Assert\Regex(pattern: '/[^A-Za-z0-9]/', message: 'Password must contain at least one special character.')]
    public string $password;

    #[Assert\NotBlank(message: 'Please confirm your password.')]
    public string $confirmPassword;
}