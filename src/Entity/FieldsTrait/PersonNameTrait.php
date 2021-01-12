<?php

declare(strict_types=1);

namespace App\Entity\FieldsTrait;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class PersonNameTrait
 */
trait PersonNameTrait
{
    /**
     * @var string
     * @ORM\Column
     */
    protected $firstName;

    /**
     * @var string
     * @ORM\Column
     */
    protected $lastName;

    /**
     * @var string
     * @ORM\Column
     */
    protected $patronymic;

    /**
     * @return string|null
     */
    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     *
     * @return $this
     */
    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     *
     * @return $this
     */
    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getPatronymic(): ?string
    {
        return $this->patronymic;
    }

    /**
     * @param string $patronymic
     *
     * @return $this
     */
    public function setPatronymic(string $patronymic): self
    {
        $this->patronymic = $patronymic;

        return $this;
    }
}
