<?php

namespace App\Enums;

enum UserRole: string
{
    /** role admin */
    case ADMIN = "1";
    /** role quản lý */
    case MANAGER = "2";
    /** role cộng tác viên */
    case COLLABORATOR = "3";
}
