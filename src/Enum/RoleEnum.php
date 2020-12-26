<?php

declare(strict_types=1);

namespace App\Enum;

/**
 * Class RoleEnum
 */
class RoleEnum
{
    public const ROLE_ADMIN = 'ROLE_ADMIN';
    public const ROLE_DOCTOR = 'ROLE_DOCTOR';
    public const ROLE_USER = 'ROLE_USER';

    /**
     * RoleEnum constructor.
     */
    private function __construct()
    {
    }

    /**
     * @return string[]
     */
    public function list(): array
    {
        return [
            self::ROLE_ADMIN,
            self::ROLE_DOCTOR,
            self::ROLE_USER,
        ];
    }
}
