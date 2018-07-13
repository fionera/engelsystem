<?php

namespace Engelsystem\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserAngelTypes
 *
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
     *   @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * })
     */
    private $user;

    /**
     * @var AngelType
     *
     * @ORM\ManyToOne(targetEntity="AngelType")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="angel_type_id", referencedColumnName="id")
     * })
     */
    private $angeltype;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="confirm_user_id", referencedColumnName="id")
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

    public function getAngeltype(): ?AngelType
    {
        return $this->angeltype;
    }

    public function setAngeltype(?AngelType $angeltype): self
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
