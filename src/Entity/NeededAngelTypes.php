<?php

namespace Engelsystem\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * NeededAngelTypes
 *
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
     * @var Room
     *
     * @ORM\ManyToOne(targetEntity="Room", inversedBy="neededAngelTypes")
     */
    private $room;

    /**
     * @var Shift
     *
     * @ORM\ManyToOne(targetEntity="Shift", inversedBy="neededAngelTypes")
     */
    private $shift;

    /**
     * @var Angeltype
     *
     * @ORM\ManyToOne(targetEntity="AngelType",inversedBy="neededAngelTypes")
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

    public function getShift(): ?Shift
    {
        return $this->shift;
    }

    public function setShift(?Shift $shift): self
    {
        $this->shift = $shift;

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

    public function __toString()
    {
        return 'AngelType: ' . $this->getAngelType()->getName() . '; Amount: '. $this->getCount();
    }
}
