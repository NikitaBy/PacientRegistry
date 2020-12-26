<?php

declare(strict_types=1);

namespace App\Saver;

use App\Entity\User;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class UserSaver
 */
class UserSaver
{
    /**
     * @var EntityManager
     */
    private $em;

    /**
     * UserSaver constructor.
     *
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @param User $user
     *
     * @return void
     */
    public function save(User $user): void
    {
        $this->em->persist($user);
        $this->em->flush();
    }
}
