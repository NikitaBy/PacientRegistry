<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\FieldsTrait\IdTrait;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Serializable;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use function array_search;
use function array_values;
use function in_array;
use function serialize;
use function strtoupper;

/**
 * Class User
 * @ORM\Entity
 */
class User implements UserInterface, Serializable
{
    use IdTrait;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", unique=true)
     */
    private $email;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_suspended", type="boolean")
     */
    private $isSuspended = false;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="last_login", type="datetime", nullable=true)
     */
    private $lastLogin;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", nullable=true)
     */
    private $password;

    /**
     * A non-persisted field that's used to create the encoded password.
     * @Assert\Length(
     *      min = 6,
     *      minMessage = "Your password must be at least {{ limit }} characters long.",
     * )
     * @var string
     */
    private $plainPassword;

    /**
     * @var array
     *
     * @ORM\Column(name="roles", type="json")
     */
    private $roles = [];

    /**
     * @var string
     *
     * @ORM\Column()
     */
    private $salt;

    /**
     * @var string
     * @ORM\Column(unique=true)
     */
    private $username;

    /**
     * @return string|null
     */
    public function getUsername(): ?string
    {
        return $this->username;
    }

    /**
     * @param string $username
     *
     * @return $this
     */
    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @return array
     */
    public function getRoles(): array
    {
        return $this->roles;
    }

    /**
     * @param array $roles
     *
     * @return $this
     */
    public function setRoles(array $roles): User
    {
        $this->roles = [];

        foreach ($roles as $role) {
            $this->addRole($role);
        }

        return $this;
    }

    /**
     * @param string|null $role
     *
     * @return $this
     */
    public function addRole($role)
    {
        if (!$role) {
            return $this;
        }

        $role = strtoupper($role);

        if (!in_array($role, $this->roles, true)) {
            $this->roles[] = $role;
        }

        return $this;
    }

    /**
     * @param $role
     *
     * @return $this
     */
    public function removeRole($role)
    {
        if (false !== $key = array_search(strtoupper($role), $this->roles, true)) {
            unset($this->roles[$key]);
            $this->roles = array_values($this->roles);
        }

        return $this;
    }

    /**
     * @param $role
     *
     * @return bool
     */
    public function hasRole($role)
    {
        return in_array(strtoupper($role), $this->roles, true);
    }

    /**
     * @return string|null
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * @param string $password
     *
     * @return $this
     */
    public function setPassword(string $password): User
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getSalt(): ?string
    {
        return $this->salt;
    }

    /**
     * @param string $salt
     *
     * @return $this
     */
    public function setSalt(string $salt): self
    {
        $this->salt = $salt;

        return $this;
    }

    /**
     * @return $this
     */
    public function eraseCredentials(): User
    {
        $this->plainPassword = null;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    /**
     * @param string|null $plainPassword
     *
     * @return $this
     */
    public function setPlainPassword(string $plainPassword = null): User
    {
        $this->plainPassword = $plainPassword;
        $this->password = null;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string $email
     *
     * @return $this
     */
    public function setEmail(string $email): User
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return DateTime|null
     */
    public function getLastLogin(): ?DateTime
    {
        return $this->lastLogin;
    }

    /**
     * @param DateTime $lastLogin
     *
     * @return $this
     */
    public function setLastLogin(DateTime $lastLogin): User
    {
        $this->lastLogin = $lastLogin;

        return $this;
    }

    /**
     * @return bool
     */
    public function isSuspended(): bool
    {
        return $this->isSuspended;
    }

    /**
     * @param bool $isSuspended
     *
     * @return $this
     */
    public function setIsSuspended(bool $isSuspended)
    {
        $this->isSuspended = $isSuspended;

        return $this;
    }

    /**
     * @return string|null
     */
    public function serialize(): ?string
    {
        return serialize(
            [
                $this->id,
                $this->email,
                $this->password,
                $this->isSuspended,
            ]
        );
    }

    public function unserialize($serialized)
    {
        //        [
        //            $this->id,
        //            $this->email,
        //            $this->password,
        //            $this->isSuspended,
        //        ] = unserialize($serialized);
    }
}
