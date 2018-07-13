<?php

namespace Engelsystem\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserWorkLog
 *
 * @ORM\Entity
 */
class UserWorkLog
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="work_timestamp", type="datetime", nullable=false)
     */
    private $workTimestamp;

    /**
     * @var string
     *
     * @ORM\Column(name="work_hours", type="decimal", precision=10, scale=2, nullable=false)
     */
    private $workHours;

    /**
     * @var string
     *
     * @ORM\Column(name="comment", type="string", nullable=false)
     */
    private $comment;

    /**
     * @var int
     *
     * @ORM\Column(name="created_timestamp", type="datetime", nullable=false)
     */
    private $createdTimestamp;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="created_user_id", referencedColumnName="id")
     * })
     */
    private $createdUser;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * })
     */
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getWorkTimestamp(): ?\DateTimeInterface
    {
        return $this->workTimestamp;
    }

    public function setWorkTimestamp(\DateTimeInterface $workTimestamp): self
    {
        $this->workTimestamp = $workTimestamp;

        return $this;
    }

    public function getWorkHours()
    {
        return $this->workHours;
    }

    public function setWorkHours($workHours): self
    {
        $this->workHours = $workHours;

        return $this;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(string $comment): self
    {
        $this->comment = $comment;

        return $this;
    }

    public function getCreatedTimestamp(): ?\DateTimeInterface
    {
        return $this->createdTimestamp;
    }

    public function setCreatedTimestamp(\DateTimeInterface $createdTimestamp): self
    {
        $this->createdTimestamp = $createdTimestamp;

        return $this;
    }

    public function getCreatedUser(): ?User
    {
        return $this->createdUser;
    }

    public function setCreatedUser(?User $createdUser): self
    {
        $this->createdUser = $createdUser;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

}