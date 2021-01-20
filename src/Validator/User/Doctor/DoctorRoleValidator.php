<?php

declare(strict_types=1);

namespace App\Validator\User\Doctor;

use App\Entity\User;
use App\Enum\RoleEnum;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

/**
 * Class DoctorRoleValidator
 */
class DoctorRoleValidator extends ConstraintValidator
{
    /**
     * @param User       $user
     * @param Constraint $constraint
     *
     * @return void
     */
    public function validate($user, Constraint $constraint): void
    {
        if (!$constraint instanceof DoctorRole) {
            throw new UnexpectedTypeException($constraint, DoctorRole::class);
        }

        if (!$user) {
            return;
        }

        if (!$user->hasRole(RoleEnum::ROLE_DOCTOR) && $user->getDoctorProfile()) {
            $this->context
                ->buildViolation($constraint->userNotDoctor)
                ->addViolation();
        }
    }
}
