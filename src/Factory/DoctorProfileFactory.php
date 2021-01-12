<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\DoctorProfile;
use App\Entity\User;
use App\Enum\RoleEnum;

/**
 * Class DoctorProfileFactory
 */
class DoctorProfileFactory
{
    /**
     * @return DoctorProfile
     */
    public function create(): DoctorProfile
    {
        $doctor = new DoctorProfile();
        $user = new User();

        $user->addRole(RoleEnum::ROLE_DOCTOR);
        $doctor->setUser($user);

        return $doctor;
    }
}
