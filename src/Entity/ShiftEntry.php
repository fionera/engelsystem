<?php

namespace Engelsystem\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ShiftEntry
 *
 * @ORM\Entity
 */
class ShiftEntry
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
     * @var string|null
     *
     * @ORM\Column(name="comment", type="text", nullable=true)
     */
    private $comment;

    /**
     * @var string|null
     *
     * @ORM\Column(name="freeload_comment", type="text", nullable=true)
     */
    private $freeloadComment;

    /**
     * @var bool
     *
     * @ORM\Column(name="freeloaded", type="boolean", nullable=false)
     */
    private $freeloaded;

    /**
     * @var Shift
     *
     * @ORM\ManyToOne(targetEntity="Shift")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="shift_id", referencedColumnName="id")
     * })
     */
    private $shift;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * })
     */
    private $user;

    /**
     * @var Angeltype
     *
     * @ORM\ManyToOne(targetEntity="AngelType")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="angel_type_id", referencedColumnName="id")
     * })
     */
    private $angelType;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): self
    {
        $this->comment = $comment;

        return $this;
    }

    public function getFreeloadComment(): ?string
    {
        return $this->freeloadComment;
    }

    public function setFreeloadComment(?string $freeloadComment): self
    {
        $this->freeloadComment = $freeloadComment;

        return $this;
    }

    public function getFreeloaded(): ?bool
    {
        return $this->freeloaded;
    }

    public function setFreeloaded(bool $freeloaded): self
    {
        $this->freeloaded = $freeloaded;

        return $this;
    }

    public function getShift(): ?Shift
    {
        return $this->shift;
    }

    public function setShift(?Shift $shift): self
    {
        $this->shift = $shift;

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

    public function getAngelType(): ?AngelType
    {
        return $this->angelType;
    }

    public function setAngelType(?AngelType $angelType): self
    {
        $this->angelType = $angelType;

        return $this;
    }

}
