<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\User;

/**
 * Class UserFactory
 */
class UserFactory
{
    /**
     * @return User
     */
    public function create(): User
    {
        return new User();
    }
}
