<?php

namespace Engelsystem\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserDriverLicenses
 *
 * @ORM\Entity
 */
class UserDriverLicenses
{
    /**
     * @var bool
     *
     * @ORM\Column(name="has_car", type="boolean", nullable=false)
     */
    private $hasCar;

    /**
     * @var bool
     *
     * @ORM\Column(name="has_license_car", type="boolean", nullable=false)
     */
    private $hasLicenseCar;

    /**
     * @var bool
     *
     * @ORM\Column(name="has_license_3_5t_transporter", type="boolean", nullable=false)
     */
    private $hasLicense35tTransporter;

    /**
     * @var bool
     *
     * @ORM\Column(name="has_license_7_5t_truck", type="boolean", nullable=false)
     */
    private $hasLicense75tTruck;

    /**
     * @var bool
     *
     * @ORM\Column(name="has_license_12_5t_truck", type="boolean", nullable=false)
     */
    private $hasLicense125tTruck;

    /**
     * @var bool
     *
     * @ORM\Column(name="has_license_forklift", type="boolean", nullable=false)
     */
    private $hasLicenseForklift;

    /**
     * @var User
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * })
     */
    private $user;

    public function getHasCar(): ?bool
    {
        return $this->hasCar;
    }

    public function setHasCar(bool $hasCar): self
    {
        $this->hasCar = $hasCar;

        return $this;
    }

    public function getHasLicenseCar(): ?bool
    {
        return $this->hasLicenseCar;
    }

    public function setHasLicenseCar(bool $hasLicenseCar): self
    {
        $this->hasLicenseCar = $hasLicenseCar;

        return $this;
    }

    public function getHasLicense35tTransporter(): ?bool
    {
        return $this->hasLicense35tTransporter;
    }

    public function setHasLicense35tTransporter(bool $hasLicense35tTransporter): self
    {
        $this->hasLicense35tTransporter = $hasLicense35tTransporter;

        return $this;
    }

    public function getHasLicense75tTruck(): ?bool
    {
        return $this->hasLicense75tTruck;
    }

    public function setHasLicense75tTruck(bool $hasLicense75tTruck): self
    {
        $this->hasLicense75tTruck = $hasLicense75tTruck;

        return $this;
    }

    public function getHasLicense125tTruck(): ?bool
    {
        return $this->hasLicense125tTruck;
    }

    public function setHasLicense125tTruck(bool $hasLicense125tTruck): self
    {
        $this->hasLicense125tTruck = $hasLicense125tTruck;

        return $this;
    }

    public function getHasLicenseForklift(): ?bool
    {
        return $this->hasLicenseForklift;
    }

    public function setHasLicenseForklift(bool $hasLicenseForklift): self
    {
        $this->hasLicenseForklift = $hasLicenseForklift;

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

}
