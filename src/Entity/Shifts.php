<?php

namespace Engelsystem\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Shifts
 *
 * @ORM\Table(name="Shifts", uniqueConstraints={@ORM\UniqueConstraint(name="PSID", columns={"PSID"})}, indexes={@ORM\Index(name="RID", columns={"RID"}), @ORM\Index(name="shifttype_id", columns={"shifttype_id"}), @ORM\Index(name="created_by_user_id", columns={"created_by_user_id"}), @ORM\Index(name="edited_by_user_id", columns={"edited_by_user_id"}), @ORM\Index(name="start", columns={"start"})})
 * @ORM\Entity
 */
class Shifts
{
    /**
     * @var int
     *
     * @ORM\Column(name="SID", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $sid;

    /**
     * @var string|null
     *
     * @ORM\Column(name="title", type="text", length=65535, nullable=true)
     */
    private $title;

    /**
     * @var int
     *
     * @ORM\Column(name="start", type="integer", nullable=false)
     */
    private $start;

    /**
     * @var int
     *
     * @ORM\Column(name="end", type="integer", nullable=false)
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
     * @ORM\Column(name="created_at_timestamp", type="integer", nullable=false)
     */
    private $createdAtTimestamp;

    /**
     * @var int
     *
     * @ORM\Column(name="edited_at_timestamp", type="integer", nullable=false)
     */
    private $editedAtTimestamp;

    /**
     * @var Room
     *
     * @ORM\ManyToOne(targetEntity="Room")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="RID", referencedColumnName="RID")
     * })
     */
    private $rid;

    /**
     * @var Shifttypes
     *
     * @ORM\ManyToOne(targetEntity="ShiftTypes")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="shifttype_id", referencedColumnName="id")
     * })
     */
    private $shifttype;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="created_by_user_id", referencedColumnName="UID")
     * })
     */
    private $createdByUser;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="edited_by_user_id", referencedColumnName="UID")
     * })
     */
    private $editedByUser;

    public function getSid(): ?int
    {
        return $this->sid;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getStart(): ?int
    {
        return $this->start;
    }

    public function setStart(int $start): self
    {
        $this->start = $start;

        return $this;
    }

    public function getEnd(): ?int
    {
        return $this->end;
    }

    public function setEnd(int $end): self
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

    public function getCreatedAtTimestamp(): ?int
    {
        return $this->createdAtTimestamp;
    }

    public function setCreatedAtTimestamp(int $createdAtTimestamp): self
    {
        $this->createdAtTimestamp = $createdAtTimestamp;

        return $this;
    }

    public function getEditedAtTimestamp(): ?int
    {
        return $this->editedAtTimestamp;
    }

    public function setEditedAtTimestamp(int $editedAtTimestamp): self
    {
        $this->editedAtTimestamp = $editedAtTimestamp;

        return $this;
    }

    public function getRid(): ?Room
    {
        return $this->rid;
    }

    public function setRid(?Room $rid): self
    {
        $this->rid = $rid;

        return $this;
    }

    public function getShifttype(): ?ShiftTypes
    {
        return $this->shifttype;
    }

    public function setShifttype(?ShiftTypes $shifttype): self
    {
        $this->shifttype = $shifttype;

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
