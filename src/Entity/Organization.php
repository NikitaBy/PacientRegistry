<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\FieldsTrait\DescriptionTrait;
use App\Entity\FieldsTrait\IdTrait;
use App\Entity\FieldsTrait\NameTrait;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Organization
 * @TODO need extra properties?
 * @ORM\Entity
 */
class Organization
{
    use DescriptionTrait;
    use IdTrait;
    use NameTrait;

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->getName() ?: 'new org';
    }
}
