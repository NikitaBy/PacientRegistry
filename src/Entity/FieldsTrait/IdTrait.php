<?php

namespace App\Entity\FieldsTrait;

use Doctrine\ORM\Mapping as ORM;

trait IdTrait
{
    /**
     * @var int
     *
     *
     * @ORM\Id()
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }
}
