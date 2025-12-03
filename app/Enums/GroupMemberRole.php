<?php

namespace App\Enums;

enum GroupMemberRole: int
{
    case ADMIN  = 1;
    case MEMBER = 2;
}