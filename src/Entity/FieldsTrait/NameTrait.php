<?php

namespace App\Entity\FieldsTrait;

use Doctrine\ORM\Mapping as ORM;

trait NameTrait
{
    /**
     * @var string
     * @ORM\Column
     */
    protected $name;

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return $this
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }
}
