<?php

declare(strict_types=1);

namespace App\Entity\FieldsTrait;

use App\Entity\User;
use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class CreatedTrait
 */
trait CreatedTrait
{
    /**
     * @var DateTime
     *
     * @ORM\Column(type="datetime", options={"default": "CURRENT_TIMESTAMP"})
     */
    protected $createdAt;

    /**
     * @var User
     *
     * @ORM\Column
     */
    protected $createdBy;

    /**
     * @return DateTime
     */
    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param DateTime $createdAt
     *
     * @return $this
     */
    public function setCreatedAt(DateTime $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return User
     */
    public function getCreatedBy(): User
    {
        return $this->createdBy;
    }

    /**
     * @param User $createdBy
     *
     * @return $this
     */
    public function setCreatedBy(User $createdBy): self
    {
        $this->createdBy = $createdBy;

        return $this;
    }
}
