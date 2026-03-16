<?php

namespace App\Dto\Auth;

use Symfony\Component\Validator\Constraints as Assert;

class VerifyResetCodeInput
{
    #[Assert\NotBlank(message: 'Email is required.')]
    #[Assert\Email(mode: 'html5', message: 'Please provide a valid email.')]
    public string $email;

    #[Assert\NotBlank(message: 'Code is required.')]
    #[Assert\Length(exactly: 6, exactMessage: 'Code must be exactly 6 characters.')]
    #[Assert\Regex(pattern: '/^\d{6}$/', message: 'Code must contain only digits.')]
    public string $code;
}