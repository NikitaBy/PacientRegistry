<?php

declare(strict_types=1);

namespace App\Entity\FieldsTrait;

use App\Entity\User;
use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class UpdatedTrait
 */
trait UpdatedTrait
{
    /**
     * @var DateTime
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $updatedAt;

    /**
     * @var User
     * @ORM\Column(nullable=true)
     */
    protected $updatedBy;

    /**
     * @return DateTime
     */
    public function getUpdatedAt(): DateTime
    {
        return $this->updatedAt;
    }

    /**
     * @param DateTime $updatedAt
     *
     * @return $this
     */
    public function setUpdatedAt(DateTime $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @return User
     */
    public function getUpdatedBy(): User
    {
        return $this->updatedBy;
    }

    /**
     * @param User $updatedBy
     *
     * @return $this
     */
    public function setUpdatedBy(User $updatedBy): self
    {
        $this->updatedBy = $updatedBy;

        return $this;
    }
}
