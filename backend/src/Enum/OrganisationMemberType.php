<?php

namespace App\Enum;

enum OrganisationMemberType: string
{
    case OWNER = 'owner';
    case STAFF = 'staff';
    case INSTRUCTOR = 'instructor';
    case STUDENT = 'student';
}