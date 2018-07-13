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
     * @ORM\ManyToMany(targetEntity="Permission")
     * @ORM\JoinTable(name="GroupPermissions",
     *      joinColumns={@ORM\JoinColumn(name="privilege_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="group_id", referencedColumnName="id")}
     *      )
     * @var Permission[]
     */
    private $permissions;

    public function __construct()
    {
        $this->permissions = new ArrayCollection();
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
     * @return Collection|Permission[]
     */
    public function getPermissions(): Collection
    {
        return $this->permissions;
    }

    public function addPermission(Permission $privilege): self
    {
        if (!$this->permissions->contains($privilege)) {
            $this->permissions[] = $privilege;
        }

        return $this;
    }

    public function removePermission(Permission $privilege): self
    {
        if ($this->permissions->contains($privilege)) {
            $this->permissions->removeElement($privilege);
        }

        return $this;
    }

    public function hasPermission(string $wantedPermission) {
        foreach ($this->getPermissions() as $permission) {
            if ($permission->getName() === $wantedPermission) {
                return true;
            }
        }

        return false;
    }

    public function __toString()
    {
        return $this->name;
    }
}
