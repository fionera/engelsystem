<?php

namespace Engelsystem\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserAngelTypes
 *
 * @ORM\Table(name="UserAngelTypes", indexes={@ORM\Index(name="user_id", columns={"user_id", "angeltype_id", "confirm_user_id"}), @ORM\Index(name="angeltype_id", columns={"angeltype_id"}), @ORM\Index(name="confirm_user_id", columns={"confirm_user_id"}), @ORM\Index(name="coordinator", columns={"supporter"}), @ORM\Index(name="IDX_A40E5E17A76ED395", columns={"user_id"})})
 * @ORM\Entity
 */
class UserAngelTypes
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
     * @var bool|null
     *
     * @ORM\Column(name="supporter", type="boolean", nullable=true)
     */
    private $supporter;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_id", referencedColumnName="UID")
     * })
     */
    private $user;

    /**
     * @var Angeltypes
     *
     * @ORM\ManyToOne(targetEntity="AngelTypes")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="angeltype_id", referencedColumnName="id")
     * })
     */
    private $angeltype;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="confirm_user_id", referencedColumnName="UID")
     * })
     */
    private $confirmUser;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSupporter(): ?bool
    {
        return $this->supporter;
    }

    public function setSupporter(?bool $supporter): self
    {
        $this->supporter = $supporter;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

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

    public function getConfirmUser(): ?User
    {
        return $this->confirmUser;
    }

    public function setConfirmUser(?User $confirmUser): self
    {
        $this->confirmUser = $confirmUser;

        return $this;
    }


}
