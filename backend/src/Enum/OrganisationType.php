<?php

namespace App\Enum;

enum OrganisationType: string
{
    case CENTER = 'center';
    case SCHOOL = 'school';
    case COLLEGE = 'college';
    case UNIVERSITY = 'university';
    case TEAM = 'team';
    case OTHER = 'other';
}