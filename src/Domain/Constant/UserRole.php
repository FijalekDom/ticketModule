<?php

namespace App\Domain\Constant;

class UserRole
{
    const ROLE_ADMIN = 'ROLE_ADMIN';
    const ROLE_CLIENT = 'ROLE_CLIENT';

    public static function getAvailableRoles(): array
    {
        return [
            self::ROLE_ADMIN,
            self::ROLE_CLIENT
        ];
    }

}