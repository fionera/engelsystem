<?php

namespace Engelsystem\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserAngelTypes
 *
 * @ORM\Entity
 * @ORM\Table(name="user_angel_types",uniqueConstraints={@ORM\UniqueConstraint(name="user_angel_type_unique", columns={"user_id", "angel_type_id"})})
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
     * @var bool
     *
     * @ORM\Column(name="coordinator", type="boolean", nullable=false)
     */
    private $coordinator = false;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User", inversedBy="userAngelTypes")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false)
     */
    private $user;

    /**
     * @var AngelType
     *
     * @ORM\ManyToOne(targetEntity="AngelType", inversedBy="userAngelTypes")
     * @ORM\JoinColumn(name="angel_type_id", referencedColumnName="id", nullable=false)
     */
    private $angelType;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="confirm_user_id", referencedColumnName="id", nullable=true)
     */
    private $confirmUser;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function isCoordinator(): bool
    {
        return $this->coordinator;
    }

    public function setCoordinator(?bool $coordinator): self
    {
        $this->coordinator = $coordinator;

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

    public function getAngelType(): ?AngelType
    {
        return $this->angelType;
    }

    public function setAngelType(?AngelType $angelType): self
    {
        $this->angelType = $angelType;

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

    public function __toString()
    {
        return $this->user->getUsername() . '/' . $this->angelType->getName();
    }
}
