<?php

namespace App\Enum;

enum UserTokenType: string
{
    case EMAIL_VERIFICATION = 'email_verification';
    case PASSWORD_RESET = 'password_reset';
    case MAGIC_LINK = 'magic_link';
    case INVITATION = 'invitation';
    case EMAIL_CHANGE = 'email_change';
    case PHONE_VERIFICATION = 'phone_verification';
    case TWO_FACTOR = 'two_factor';
}