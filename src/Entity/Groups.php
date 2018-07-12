<?php

namespace Engelsystem\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Groups
 *
 * @ORM\Table(name="Groups")
 * @ORM\Entity
 */
class Groups
{
    /**
     * @var string
     *
     * @ORM\Column(name="Name", type="string", length=35, nullable=false)
     */
    private $name;

    /**
     * @var int
     *
     * @ORM\Column(name="UID", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $uid;

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getUid(): ?int
    {
        return $this->uid;
    }


}
