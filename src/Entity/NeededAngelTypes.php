<?php

namespace Engelsystem\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * NeededAngelTypes
 *
 * @ORM\Table(name="NeededAngelTypes", indexes={@ORM\Index(name="room_id", columns={"room_id", "angel_type_id"}), @ORM\Index(name="shift_id", columns={"shift_id"}), @ORM\Index(name="angel_type_id", columns={"angel_type_id"}), @ORM\Index(name="count", columns={"count"}), @ORM\Index(name="IDX_C2AA7D0254177093", columns={"room_id"})})
 * @ORM\Entity
 */
class NeededAngelTypes
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
     * @ORM\Column(name="count", type="integer", nullable=false)
     */
    private $count;

    /**
     * @var \Room
     *
     * @ORM\ManyToOne(targetEntity="Room")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="room_id", referencedColumnName="RID")
     * })
     */
    private $room;

    /**
     * @var \Shifts
     *
     * @ORM\ManyToOne(targetEntity="Shifts")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="shift_id", referencedColumnName="SID")
     * })
     */
    private $shift;

    /**
     * @var \Angeltypes
     *
     * @ORM\ManyToOne(targetEntity="AngelTypes")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="angel_type_id", referencedColumnName="id")
     * })
     */
    private $angelType;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCount(): ?int
    {
        return $this->count;
    }

    public function setCount(int $count): self
    {
        $this->count = $count;

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

    public function getShift(): ?Shifts
    {
        return $this->shift;
    }

    public function setShift(?Shifts $shift): self
    {
        $this->shift = $shift;

        return $this;
    }

    public function getAngelType(): ?AngelTypes
    {
        return $this->angelType;
    }

    public function setAngelType(?AngelTypes $angelType): self
    {
        $this->angelType = $angelType;

        return $this;
    }


}
