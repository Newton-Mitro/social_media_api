<?php

namespace App\Core\Enums;

enum TokenAbility: string
{
    case ISSUE_ACCESS_TOKEN = 'issue-access-token';
    case ACCESS_API = 'access-api';
}
