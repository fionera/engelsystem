<?php

namespace Engelsystem\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * AngelType
 *
 * @ORM\Entity
 */
class AngelType
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
     * @var boolean
     *
     * @ORM\Column(name="restricted", type="boolean", nullable=false)
     */
    private $restricted;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=false)
     */
    private $description;

    /**
     * @var bool
     *
     * @ORM\Column(name="requires_driver_license", type="boolean", nullable=false)
     */
    private $requiresDriverLicense;

    /**
     * @var bool
     *
     * @ORM\Column(name="no_self_signup", type="boolean", nullable=false)
     */
    private $noSelfSignup;

    /**
     * @var string|null
     *
     * @ORM\Column(name="contact_name", type="string", nullable=true)
     */
    private $contactName;

    /**
     * @var string|null
     *
     * @ORM\Column(name="contact_dect", type="string", nullable=true)
     */
    private $contactDect;

    /**
     * @var string|null
     *
     * @ORM\Column(name="contact_email", type="string", nullable=true)
     */
    private $contactEmail;

    /**
     * @var bool
     *
     * @ORM\Column(name="show_on_dashboard", type="boolean", nullable=false)
     */
    private $showOnDashboard;

    /**
     * @var UserAngelTypes[]|Collection
     *
     * @ORM\OneToMany(targetEntity="Engelsystem\Entity\UserAngelTypes", mappedBy="angelType", orphanRemoval=true)
     */
    private $userAngelTypes;

    /**
     * @var NeededAngelTypes[]|Collection
     *
     * @ORM\OneToMany(targetEntity="Engelsystem\Entity\NeededAngelTypes", mappedBy="angelType", orphanRemoval=true)
     */
    private $neededAngelTypes;

    /**
     * @var ShiftType[]|Collection
     *
     * @ORM\OneToMany(targetEntity="ShiftType", mappedBy="angelType")
     */
    private $shiftType;

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

    public function getRestricted(): ?bool
    {
        return $this->restricted;
    }

    public function setRestricted(?bool $restricted): self
    {
        $this->restricted = $restricted;

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

    public function getRequiresDriverLicense(): ?bool
    {
        return $this->requiresDriverLicense;
    }

    public function setRequiresDriverLicense(bool $requiresDriverLicense): self
    {
        $this->requiresDriverLicense = $requiresDriverLicense;

        return $this;
    }

    public function getNoSelfSignup(): ?bool
    {
        return $this->noSelfSignup;
    }

    public function setNoSelfSignup(bool $noSelfSignup): self
    {
        $this->noSelfSignup = $noSelfSignup;

        return $this;
    }

    public function getContactName(): ?string
    {
        return $this->contactName;
    }

    public function setContactName(?string $contactName): self
    {
        $this->contactName = $contactName;

        return $this;
    }

    public function getContactDect(): ?string
    {
        return $this->contactDect;
    }

    public function setContactDect(?string $contactDect): self
    {
        $this->contactDect = $contactDect;

        return $this;
    }

    public function getContactEmail(): ?string
    {
        return $this->contactEmail;
    }

    public function setContactEmail(?string $contactEmail): self
    {
        $this->contactEmail = $contactEmail;

        return $this;
    }

    public function getShowOnDashboard(): ?bool
    {
        return $this->showOnDashboard;
    }

    public function setShowOnDashboard(bool $showOnDashboard): self
    {
        $this->showOnDashboard = $showOnDashboard;

        return $this;
    }

    /**
     * @return Collection|UserAngelTypes[]
     */
    public function getUserAngelTypes()
    {
        return $this->userAngelTypes ?? new ArrayCollection();
    }

    /**
     * @return Collection|NeededAngelTypes[]
     */
    public function getNeededAngelTypes()
    {
        return $this->neededAngelTypes ?? new ArrayCollection();
    }

    /**
     * @return Collection|ShiftType[]
     */
    public function getShiftTypes()
    {
        return $this->shiftType ?? new ArrayCollection();
    }

    public function __toString()
    {
        return $this->name;
    }
}
