<?php

declare(strict_types=1);

namespace App\Security;

use App\Entity\User;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class UserPasswordUpdater
 */
class UserPasswordUpdater
{
    /**
     * @var UserPasswordEncoder
     */
    private $encoder;

    /**
     * UserPasswordUpdater constructor.
     *
     * @param UserPasswordEncoderInterface $encoder
     */
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    /**
     * @param User $user
     *
     * @return void
     */
    public function updatePassword(User $user): void
    {
        if (!$plainPassword = $user->getPlainPassword()) {
            return;
        }

        $user->setPassword($this->encoder->encodePassword($user, $plainPassword));
    }
}
