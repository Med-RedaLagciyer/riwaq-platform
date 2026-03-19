<?php

namespace App\Enum;

enum OrganisationVisibilityField: string
{
    case DESCRIPTION = 'description';
    case ADDRESS = 'address';
    case CITY = 'city';
    case COUNTRY = 'country';
    case POSTAL_CODE = 'postal_code';
    case PRIMARY_PHONE = 'primary_phone';
    case SECONDARY_PHONE = 'secondary_phone';
    case PRIMARY_EMAIL = 'primary_email';
    case SECONDARY_EMAIL = 'secondary_email';
    case WEBSITE = 'website';
}