<?php

declare(strict_types=1);

namespace App\Security;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use function sprintf;

/**
 * Class UserProvider
 */
class UserProvider implements UserProviderInterface
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * UserProvider constructor.
     *
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param string $username
     *
     * @return User
     */
    public function loadUserByUsername($username): User
    {
        if (!$user = $this->userRepository->findOneByUsername($username)) {
            throw new UsernameNotFoundException(sprintf('"%s" not found.', $username));
        }

        return $user;
    }

    /**
     * @param UserInterface $user
     *
     * @return User
     */
    public function refreshUser(UserInterface $user): User
    {
        /** @var User $user */
        if (!$reloadedUser = $this->userRepository->find($user->getId())) {
            throw new UsernameNotFoundException(sprintf('"%s" not found.', $user->getId()));
        }

        return $reloadedUser;
    }

    /**
     * @param string $class
     *
     * @return string
     */
    public function supportsClass($class): string
    {
        return User::class;
    }
}
