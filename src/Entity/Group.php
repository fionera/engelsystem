<?php

namespace Engelsystem\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Groups
 * @ORM\Table(name="`group`")
 * @ORM\Entity
 */
class Group
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
     * @ORM\ManyToMany(targetEntity="Privilege")
     * @ORM\JoinTable(name="GroupPrivileges",
     *      joinColumns={@ORM\JoinColumn(name="privilege_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="group_id", referencedColumnName="id")}
     *      )
     * @var Privilege[]
     */
    private $privileges;

    public function __construct()
    {
        $this->privileges = new ArrayCollection();
    }

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

    /**
     * @return Collection|Privilege[]
     */
    public function getPrivileges(): Collection
    {
        return $this->privileges;
    }

    public function addPrivilege(Privilege $privilege): self
    {
        if (!$this->privileges->contains($privilege)) {
            $this->privileges[] = $privilege;
        }

        return $this;
    }

    public function removePrivilege(Privilege $privilege): self
    {
        if ($this->privileges->contains($privilege)) {
            $this->privileges->removeElement($privilege);
        }

        return $this;
    }

    public function __toString()
    {
        return $this->name;
    }
}
