<?php

declare(strict_types=1);

namespace App\Entity\FieldsTrait;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class DescriptionTrait
 */
trait DescriptionTrait
{
    /**
     * @var string
     *
     * @ORM\Column(nullable=true)
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
     * @param string|null $description
     *
     * @return $this
     */
    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }
}
