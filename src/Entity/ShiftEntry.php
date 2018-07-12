<?php

namespace Engelsystem\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ShiftEntry
 *
 * @ORM\Table(name="ShiftEntry", indexes={@ORM\Index(name="TID", columns={"TID"}), @ORM\Index(name="UID", columns={"UID"}), @ORM\Index(name="SID", columns={"SID", "TID"}), @ORM\Index(name="freeloaded", columns={"freeloaded"}), @ORM\Index(name="IDX_CDA1BE70C1B1383E", columns={"SID"})})
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
     * @ORM\Column(name="Comment", type="text", length=65535, nullable=true)
     */
    private $comment;

    /**
     * @var string|null
     *
     * @ORM\Column(name="freeload_comment", type="text", length=65535, nullable=true)
     */
    private $freeloadComment;

    /**
     * @var bool
     *
     * @ORM\Column(name="freeloaded", type="boolean", nullable=false)
     */
    private $freeloaded;

    /**
     * @var Shifts
     *
     * @ORM\ManyToOne(targetEntity="Shifts")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="SID", referencedColumnName="SID")
     * })
     */
    private $sid;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="UID", referencedColumnName="UID")
     * })
     */
    private $uid;

    /**
     * @var \Angeltypes
     *
     * @ORM\ManyToOne(targetEntity="AngelTypes")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="TID", referencedColumnName="id")
     * })
     */
    private $tid;

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

    public function getSid(): ?Shifts
    {
        return $this->sid;
    }

    public function setSid(?Shifts $sid): self
    {
        $this->sid = $sid;

        return $this;
    }

    public function getUid(): ?User
    {
        return $this->uid;
    }

    public function setUid(?User $uid): self
    {
        $this->uid = $uid;

        return $this;
    }

    public function getTid(): ?AngelTypes
    {
        return $this->tid;
    }

    public function setTid(?AngelTypes $tid): self
    {
        $this->tid = $tid;

        return $this;
    }


}
