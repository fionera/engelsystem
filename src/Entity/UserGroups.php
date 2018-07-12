<?php

namespace Engelsystem\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserGroups
 *
 * @ORM\Table(name="UserGroups", indexes={@ORM\Index(name="uid", columns={"uid", "group_id"}), @ORM\Index(name="group_id", columns={"group_id"}), @ORM\Index(name="IDX_D0662852539B0606", columns={"uid"})})
 * @ORM\Entity
 */
class UserGroups
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
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="uid", referencedColumnName="UID")
     * })
     */
    private $uid;

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

    public function getUid(): ?User
    {
        return $this->uid;
    }

    public function setUid(?User $uid): self
    {
        $this->uid = $uid;

        return $this;
    }


}
