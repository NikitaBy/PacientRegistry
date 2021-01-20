<?php

namespace App\Entity;

use App\Entity\FieldsTrait\IdTrait;
use App\Repository\UserRepository;
use App\Validator\User\Doctor\DoctorRole;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use function array_unique;
use function in_array;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 *
 * @DoctorRole()
 */
class User implements UserInterface
{
    use IdTrait;

    /**
     * @var DoctorProfile
     * @ORM\OneToOne(targetEntity=DoctorProfile::class, mappedBy="user", cascade={"persist", "remove"})
     */
    private $doctorProfile;

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @var string
     * @Assert\Length(min="6")
     */
    private $plainPassword;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $username;

    /**
     * @return DoctorProfile|null
     */
    public function getDoctorProfile(): ?DoctorProfile
    {
        return $this->doctorProfile;
    }

    /**
     * @param DoctorProfile $doctorProfile
     *
     * @return $this
     */
    public function setDoctorProfile(DoctorProfile $doctorProfile): self
    {
        $this->doctorProfile = $doctorProfile;

        return $this;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->getUsername() ?: '';
    }

    /**
     * @return string|null
     */
    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    /**
     * @param string $plainPassword
     *
     * @return $this
     */
    public function setPlainPassword(string $plainPassword): self
    {
        $this->plainPassword = $plainPassword;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getUsername(): ?string
    {
        return (string) $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @param string $role
     *
     * @return $this
     */
    public function addRole(string $role): self
    {
        if (!in_array($role, $this->roles, true)) {
            $this->roles[] = $role;
        }

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;

        //        $roles[] = RoleEnum::ROLE_USER;

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @param string $role
     *
     * @return bool
     */
    public function hasRole(string $role): bool
    {
        return in_array($role, $this->roles, true);
    }

    /**
     * @return string|null
     */
    public function getPassword(): ?string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @return void
     */
    public function eraseCredentials(): void
    {
        $this->plainPassword = null;
    }
}
