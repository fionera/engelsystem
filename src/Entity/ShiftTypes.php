<?php

namespace Engelsystem\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ShiftTypes
 *
 * @ORM\Table(name="ShiftTypes", indexes={@ORM\Index(name="angeltype_id", columns={"angeltype_id"})})
 * @ORM\Entity
 */
class ShiftTypes
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
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", length=65535, nullable=false)
     */
    private $description;

    /**
     * @var Angeltypes
     *
     * @ORM\ManyToOne(targetEntity="AngelTypes")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="angeltype_id", referencedColumnName="id")
     * })
     */
    private $angeltype;

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

    public function getAngeltype(): ?AngelTypes
    {
        return $this->angeltype;
    }

    public function setAngeltype(?AngelTypes $angeltype): self
    {
        $this->angeltype = $angeltype;

        return $this;
    }


}
