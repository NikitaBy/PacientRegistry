<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\FieldsTrait\IdTrait;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class User
 * @ORM\Entity
 */
class User
{
    use IdTrait;

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
}
