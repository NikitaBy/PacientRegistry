<?php

declare(strict_types=1);

namespace App\Validator\User\Doctor;

use Symfony\Component\Validator\Constraint;

/**
 * Class DoctorConstraint
 * @Annotation
 */
final class DoctorRole extends Constraint
{
    /**
     * @var string
     */
    public $userIsDoctor = 'User should have doctor profile.';

    /**
     * @var string
     */
    public $userNotDoctor = 'User shouldn\'t have doctor profile.';

    /**
     * @return string
     */
    public function getTargets(): string
    {
        return self::CLASS_CONSTRAINT;
    }
}
