<?php

namespace App\Email\Auth;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;

class AccountExistsEmail extends TemplatedEmail
{
    public function __construct(string $toEmail)
    {
        parent::__construct();

        $this
            ->from('noreply@riwaq.com')
            ->to($toEmail)
            ->subject('You already have an account')
            ->htmlTemplate('emails/auth/account_exists.html.twig')
            ->context([
                'userEmail' => $toEmail,
            ]);
    }
}