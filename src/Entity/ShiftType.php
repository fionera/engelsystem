<?php

namespace Engelsystem\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * ShiftType
 *
 * @ORM\Entity
 */
class ShiftType
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
     * @var string
     *
     * @ORM\Column(name="name", type="string", nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=false)
     */
    private $description;

    /**
     * @var AngelType
     *
     * @ORM\ManyToOne(targetEntity="AngelType", inversedBy="shiftType")
     */
    private $angelType;

    /**
     * @var Shift[]|Collection
     *
     * @ORM\OneToMany(targetEntity="Shift", mappedBy="shiftType")
     */
    private $shifts;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

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

    /**
     * @return Collection
     */
    public function getShifts()
    {
        return $this->shifts;
    }

    /**
     * @param Collection $shifts
     */
    public function setShifts($shifts): void
    {
        $this->shifts = $shifts;
    }

    public function __toString()
    {
        return $this->name;
    }
}
