<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\FieldsTrait\CreatedTrait;
use App\Entity\FieldsTrait\IdTrait;
use App\Entity\FieldsTrait\PersonNameTrait;
use App\Entity\FieldsTrait\UpdatedTrait;
use Doctrine\ORM\Mapping as ORM;
use function sprintf;

/**
 * //TODO Implement Avatar
 * Class DoctorProfile
 * @ORM\Entity
 */
class DoctorProfile
{
    use CreatedTrait;
    use IdTrait;
    use PersonNameTrait;
    use UpdatedTrait;

    /**
     * @var Organization
     * @ORM\ManyToOne(targetEntity=Organization::class,)
     */
    private $organization;

    /**
     * @var User
     * @ORM\OneToOne(targetEntity=User::class, inversedBy="doctorProfile", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    public function __toString()
    {
        return sprintf('"%s %s %s"', $this->getLastName(), $this->getFirstName(), $this->getPatronymic());
    }

    /**
     * @return Organization|null
     */
    public function getOrganization(): ?Organization
    {
        return $this->organization;
    }

    /**
     * @param Organization $organization
     *
     * @return $this
     */
    public function setOrganization(Organization $organization): self
    {
        $this->organization = $organization;

        return $this;
    }

    /**
     * @return User|null
     */
    public function getUser(): ?User
    {
        return $this->user;
    }

    /**
     * @param User $user
     *
     * @return $this
     */
    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
