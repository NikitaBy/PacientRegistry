<?php

namespace App\Entity\FieldsTrait;

use Doctrine\ORM\Mapping as ORM;

trait DescriptionTrait
{
    /**
     * @var string
     *
     * @ORM\Column()
     */
    protected $description;

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string $description
     *
     * @return $this
     */
    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }
}
