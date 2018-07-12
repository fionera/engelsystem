<?php

namespace Engelsystem\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * User
 *
 * @ORM\Table(name="User", uniqueConstraints={@ORM\UniqueConstraint(name="Nick", columns={"Nick"})}, indexes={@ORM\Index(name="api_key", columns={"api_key"}), @ORM\Index(name="password_recovery_token", columns={"password_recovery_token"}), @ORM\Index(name="force_active", columns={"force_active"}), @ORM\Index(name="arrival_date", columns={"arrival_date", "planned_arrival_date"}), @ORM\Index(name="planned_departure_date", columns={"planned_departure_date"})})
 * @ORM\Entity
 */
class User
{
    /**
     * @var int
     *
     * @ORM\Column(name="UID", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $uid;

    /**
     * @var string
     *
     * @ORM\Column(name="Nick", type="string", length=23, nullable=false)
     */
    private $nick = '';

    /**
     * @var string|null
     *
     * @ORM\Column(name="Name", type="string", length=23, nullable=true)
     */
    private $name;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Vorname", type="string", length=23, nullable=true)
     */
    private $vorname;

    /**
     * @var int|null
     *
     * @ORM\Column(name="Alter", type="integer", nullable=true)
     */
    private $alter;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Telefon", type="string", length=40, nullable=true)
     */
    private $telefon;

    /**
     * @var string|null
     *
     * @ORM\Column(name="DECT", type="string", length=5, nullable=true)
     */
    private $dect;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Handy", type="string", length=40, nullable=true)
     */
    private $handy;

    /**
     * @var string|null
     *
     * @ORM\Column(name="email", type="string", length=123, nullable=true)
     */
    private $email;

    /**
     * @var bool
     *
     * @ORM\Column(name="email_shiftinfo", type="boolean", nullable=false, options={"comment"="User wants to be informed by mail about changes in his shifts"})
     */
    private $emailShiftinfo = '0';

    /**
     * @var string|null
     *
     * @ORM\Column(name="jabber", type="string", length=200, nullable=true)
     */
    private $jabber;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Size", type="string", length=4, nullable=true)
     */
    private $size;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Passwort", type="string", length=128, nullable=true)
     */
    private $passwort;

    /**
     * @var string|null
     *
     * @ORM\Column(name="password_recovery_token", type="string", length=32, nullable=true)
     */
    private $passwordRecoveryToken;

    /**
     * @var bool
     *
     * @ORM\Column(name="Gekommen", type="boolean", nullable=false)
     */
    private $gekommen = '0';

    /**
     * @var bool
     *
     * @ORM\Column(name="Aktiv", type="boolean", nullable=false)
     */
    private $aktiv = '0';

    /**
     * @var bool
     *
     * @ORM\Column(name="force_active", type="boolean", nullable=false)
     */
    private $forceActive;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="Tshirt", type="boolean", nullable=true)
     */
    private $tshirt = '0';

    /**
     * @var bool|null
     *
     * @ORM\Column(name="color", type="boolean", nullable=true, options={"default"="10"})
     */
    private $color = '10';

    /**
     * @var string
     *
     * @ORM\Column(name="Sprache", type="string", length=64, nullable=false, options={"fixed"=true})
     */
    private $sprache;

    /**
     * @var string
     *
     * @ORM\Column(name="Menu", type="string", length=1, nullable=false, options={"default"="L","fixed"=true})
     */
    private $menu = 'L';

    /**
     * @var int
     *
     * @ORM\Column(name="lastLogIn", type="integer", nullable=false)
     */
    private $lastlogin;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="CreateDate", type="datetime", nullable=false, options={"default"="1000-01-01 00:00:00"})
     */
    private $createdate = '1000-01-01 00:00:00';

    /**
     * @var string|null
     *
     * @ORM\Column(name="Art", type="string", length=30, nullable=true)
     */
    private $art;

    /**
     * @var string|null
     *
     * @ORM\Column(name="kommentar", type="text", length=65535, nullable=true)
     */
    private $kommentar;

    /**
     * @var string
     *
     * @ORM\Column(name="Hometown", type="string", length=255, nullable=false)
     */
    private $hometown = '';

    /**
     * @var string
     *
     * @ORM\Column(name="api_key", type="string", length=32, nullable=false)
     */
    private $apiKey;

    /**
     * @var int
     *
     * @ORM\Column(name="got_voucher", type="integer", nullable=false)
     */
    private $gotVoucher;

    /**
     * @var int|null
     *
     * @ORM\Column(name="arrival_date", type="integer", nullable=true)
     */
    private $arrivalDate;

    /**
     * @var int
     *
     * @ORM\Column(name="planned_arrival_date", type="integer", nullable=false)
     */
    private $plannedArrivalDate;

    /**
     * @var int|null
     *
     * @ORM\Column(name="planned_departure_date", type="integer", nullable=true)
     */
    private $plannedDepartureDate;

    /**
     * @var bool
     *
     * @ORM\Column(name="email_by_human_allowed", type="boolean", nullable=false)
     */
    private $emailByHumanAllowed;

    public function getUid(): ?int
    {
        return $this->uid;
    }

    public function getNick(): ?string
    {
        return $this->nick;
    }

    public function setNick(string $nick): self
    {
        $this->nick = $nick;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getVorname(): ?string
    {
        return $this->vorname;
    }

    public function setVorname(?string $vorname): self
    {
        $this->vorname = $vorname;

        return $this;
    }

    public function getAlter(): ?int
    {
        return $this->alter;
    }

    public function setAlter(?int $alter): self
    {
        $this->alter = $alter;

        return $this;
    }

    public function getTelefon(): ?string
    {
        return $this->telefon;
    }

    public function setTelefon(?string $telefon): self
    {
        $this->telefon = $telefon;

        return $this;
    }

    public function getDect(): ?string
    {
        return $this->dect;
    }

    public function setDect(?string $dect): self
    {
        $this->dect = $dect;

        return $this;
    }

    public function getHandy(): ?string
    {
        return $this->handy;
    }

    public function setHandy(?string $handy): self
    {
        $this->handy = $handy;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getEmailShiftinfo(): ?bool
    {
        return $this->emailShiftinfo;
    }

    public function setEmailShiftinfo(bool $emailShiftinfo): self
    {
        $this->emailShiftinfo = $emailShiftinfo;

        return $this;
    }

    public function getJabber(): ?string
    {
        return $this->jabber;
    }

    public function setJabber(?string $jabber): self
    {
        $this->jabber = $jabber;

        return $this;
    }

    public function getSize(): ?string
    {
        return $this->size;
    }

    public function setSize(?string $size): self
    {
        $this->size = $size;

        return $this;
    }

    public function getPasswort(): ?string
    {
        return $this->passwort;
    }

    public function setPasswort(?string $passwort): self
    {
        $this->passwort = $passwort;

        return $this;
    }

    public function getPasswordRecoveryToken(): ?string
    {
        return $this->passwordRecoveryToken;
    }

    public function setPasswordRecoveryToken(?string $passwordRecoveryToken): self
    {
        $this->passwordRecoveryToken = $passwordRecoveryToken;

        return $this;
    }

    public function getGekommen(): ?bool
    {
        return $this->gekommen;
    }

    public function setGekommen(bool $gekommen): self
    {
        $this->gekommen = $gekommen;

        return $this;
    }

    public function getAktiv(): ?bool
    {
        return $this->aktiv;
    }

    public function setAktiv(bool $aktiv): self
    {
        $this->aktiv = $aktiv;

        return $this;
    }

    public function getForceActive(): ?bool
    {
        return $this->forceActive;
    }

    public function setForceActive(bool $forceActive): self
    {
        $this->forceActive = $forceActive;

        return $this;
    }

    public function getTshirt(): ?bool
    {
        return $this->tshirt;
    }

    public function setTshirt(?bool $tshirt): self
    {
        $this->tshirt = $tshirt;

        return $this;
    }

    public function getColor(): ?bool
    {
        return $this->color;
    }

    public function setColor(?bool $color): self
    {
        $this->color = $color;

        return $this;
    }

    public function getSprache(): ?string
    {
        return $this->sprache;
    }

    public function setSprache(string $sprache): self
    {
        $this->sprache = $sprache;

        return $this;
    }

    public function getMenu(): ?string
    {
        return $this->menu;
    }

    public function setMenu(string $menu): self
    {
        $this->menu = $menu;

        return $this;
    }

    public function getLastlogin(): ?int
    {
        return $this->lastlogin;
    }

    public function setLastlogin(int $lastlogin): self
    {
        $this->lastlogin = $lastlogin;

        return $this;
    }

    public function getCreatedate(): ?\DateTimeInterface
    {
        return $this->createdate;
    }

    public function setCreatedate(\DateTimeInterface $createdate): self
    {
        $this->createdate = $createdate;

        return $this;
    }

    public function getArt(): ?string
    {
        return $this->art;
    }

    public function setArt(?string $art): self
    {
        $this->art = $art;

        return $this;
    }

    public function getKommentar(): ?string
    {
        return $this->kommentar;
    }

    public function setKommentar(?string $kommentar): self
    {
        $this->kommentar = $kommentar;

        return $this;
    }

    public function getHometown(): ?string
    {
        return $this->hometown;
    }

    public function setHometown(string $hometown): self
    {
        $this->hometown = $hometown;

        return $this;
    }

    public function getApiKey(): ?string
    {
        return $this->apiKey;
    }

    public function setApiKey(string $apiKey): self
    {
        $this->apiKey = $apiKey;

        return $this;
    }

    public function getGotVoucher(): ?int
    {
        return $this->gotVoucher;
    }

    public function setGotVoucher(int $gotVoucher): self
    {
        $this->gotVoucher = $gotVoucher;

        return $this;
    }

    public function getArrivalDate(): ?int
    {
        return $this->arrivalDate;
    }

    public function setArrivalDate(?int $arrivalDate): self
    {
        $this->arrivalDate = $arrivalDate;

        return $this;
    }

    public function getPlannedArrivalDate(): ?int
    {
        return $this->plannedArrivalDate;
    }

    public function setPlannedArrivalDate(int $plannedArrivalDate): self
    {
        $this->plannedArrivalDate = $plannedArrivalDate;

        return $this;
    }

    public function getPlannedDepartureDate(): ?int
    {
        return $this->plannedDepartureDate;
    }

    public function setPlannedDepartureDate(?int $plannedDepartureDate): self
    {
        $this->plannedDepartureDate = $plannedDepartureDate;

        return $this;
    }

    public function getEmailByHumanAllowed(): ?bool
    {
        return $this->emailByHumanAllowed;
    }

    public function setEmailByHumanAllowed(bool $emailByHumanAllowed): self
    {
        $this->emailByHumanAllowed = $emailByHumanAllowed;

        return $this;
    }


}
