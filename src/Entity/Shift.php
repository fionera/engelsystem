<?php

namespace Engelsystem\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Shifts
 *
 * @ORM\Entity
 */
class Shift
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
     * @ORM\Column(name="title", type="text", length=65535, nullable=true)
     */
    private $name;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="start", type="datetime", nullable=false)
     */
    private $start;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="end", type="datetime", nullable=false)
     */
    private $end;

    /**
     * @var string|null
     *
     * @ORM\Column(name="URL", type="text", length=65535, nullable=true)
     */
    private $url;

    /**
     * @var int|null
     *
     * @ORM\Column(name="PSID", type="integer", nullable=true)
     */
    private $psid;

    /**
     * @var int
     *
     * @ORM\Column(name="created_at_timestamp", type="datetime", nullable=false)
     */
    private $createdAtTimestamp;

    /**
     * @var int
     *
     * @ORM\Column(name="edited_at_timestamp", type="datetime", nullable=false)
     */
    private $editedAtTimestamp;

    /**
     * @var Room
     *
     * @ORM\ManyToOne(targetEntity="Room")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="room_id", referencedColumnName="id")
     * })
     */
    private $room;

    /**
     * @var ShiftType
     *
     * @ORM\ManyToOne(targetEntity="ShiftType", inversedBy="shifts")
     */
    private $shiftType;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="created_by_user_id", referencedColumnName="id")
     * })
     */
    private $createdByUser;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="edited_by_user_id", referencedColumnName="id")
     * })
     */
    private $editedByUser;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getStart(): ?\DateTime
    {
        return $this->start;
    }

    public function setStart(\DateTime $start): self
    {
        $this->start = $start;

        return $this;
    }

    public function getEnd(): ?\DateTime
    {
        return $this->end;
    }

    public function setEnd(\DateTime $end): self
    {
        $this->end = $end;

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(?string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function getPsid(): ?int
    {
        return $this->psid;
    }

    public function setPsid(?int $psid): self
    {
        $this->psid = $psid;

        return $this;
    }

    public function getCreatedAtTimestamp(): ?\DateTime
    {
        return $this->createdAtTimestamp;
    }

    public function setCreatedAtTimestamp(\DateTime $createdAtTimestamp): self
    {
        $this->createdAtTimestamp = $createdAtTimestamp;

        return $this;
    }

    public function getEditedAtTimestamp(): ?\DateTime
    {
        return $this->editedAtTimestamp;
    }

    public function setEditedAtTimestamp(\DateTime $editedAtTimestamp): self
    {
        $this->editedAtTimestamp = $editedAtTimestamp;

        return $this;
    }

    public function getRoom(): ?Room
    {
        return $this->room;
    }

    public function setRoom(?Room $room): self
    {
        $this->room = $room;

        return $this;
    }

    public function getShiftType(): ?ShiftType
    {
        return $this->shiftType;
    }

    public function setShiftType(?ShiftType $shiftType): self
    {
        $this->shiftType = $shiftType;

        return $this;
    }

    public function getCreatedByUser(): ?User
    {
        return $this->createdByUser;
    }

    public function setCreatedByUser(?User $createdByUser): self
    {
        $this->createdByUser = $createdByUser;

        return $this;
    }

    public function getEditedByUser(): ?User
    {
        return $this->editedByUser;
    }

    public function setEditedByUser(?User $editedByUser): self
    {
        $this->editedByUser = $editedByUser;

        return $this;
    }

}
