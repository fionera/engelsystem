<?php

namespace Engelsystem\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * GroupPrivileges
 *
 * @ORM\Table(name="GroupPrivileges", indexes={@ORM\Index(name="group_id", columns={"group_id", "privilege_id"}), @ORM\Index(name="privilege_id", columns={"privilege_id"}), @ORM\Index(name="IDX_22E239A0FE54D947", columns={"group_id"})})
 * @ORM\Entity
 */
class GroupPrivileges
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
     * @var Groups
     *
     * @ORM\ManyToOne(targetEntity="Groups")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="group_id", referencedColumnName="UID")
     * })
     */
    private $group;

    /**
     * @var Privileges
     *
     * @ORM\ManyToOne(targetEntity="Privileges")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="privilege_id", referencedColumnName="id")
     * })
     */
    private $privilege;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGroup(): ?Groups
    {
        return $this->group;
    }

    public function setGroup(?Groups $group): self
    {
        $this->group = $group;

        return $this;
    }

    public function getPrivilege(): ?Privileges
    {
        return $this->privilege;
    }

    public function setPrivilege(?Privileges $privilege): self
    {
        $this->privilege = $privilege;

        return $this;
    }


}
