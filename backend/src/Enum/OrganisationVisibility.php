<?php

namespace App\Enum;

enum OrganisationVisibility: string
{
    case PUBLIC = 'public';
    case MEMBERS = 'members';
    case STAFF = 'staff';
    case OWNER = 'owner';
}