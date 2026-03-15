<?php

namespace App\Email\Auth;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;

class VerificationCodeEmail extends TemplatedEmail
{
    public function __construct(string $toEmail, string $code)
    {
        parent::__construct();

        $this
            ->from('noreply@riwaq.com')
            ->to($toEmail)
            ->subject('Your verification code')
            ->htmlTemplate('emails/auth/verification_code.html.twig')
            ->context([
                'code' => $code,
                'expires_in' => '15 minutes',
            ]);
    }
}