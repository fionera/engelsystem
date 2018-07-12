<?php

namespace Engelsystem\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Room
 *
 * @ORM\Table(name="Room", uniqueConstraints={@ORM\UniqueConstraint(name="Name", columns={"Name"})})
 * @ORM\Entity
 */
class Room
{
    /**
     * @var int
     *
     * @ORM\Column(name="RID", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $rid;

    /**
     * @var string
     *
     * @ORM\Column(name="Name", type="string", length=35, nullable=false)
     */
    private $name = '';

    /**
     * @var bool
     *
     * @ORM\Column(name="from_frab", type="boolean", nullable=false)
     */
    private $fromFrab;

    /**
     * @var string|null
     *
     * @ORM\Column(name="map_url", type="string", length=300, nullable=true)
     */
    private $mapUrl;

    /**
     * @var string|null
     *
     * @ORM\Column(name="description", type="text", length=65535, nullable=true)
     */
    private $description;

    public function getRid(): ?int
    {
        return $this->rid;
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

    public function getFromFrab(): ?bool
    {
        return $this->fromFrab;
    }

    public function setFromFrab(bool $fromFrab): self
    {
        $this->fromFrab = $fromFrab;

        return $this;
    }

    public function getMapUrl(): ?string
    {
        return $this->mapUrl;
    }

    public function setMapUrl(?string $mapUrl): self
    {
        $this->mapUrl = $mapUrl;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }


}
