<?php

namespace Engelsystem\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * User
 * @ORM\Entity
 */
class User implements UserInterface, \Serializable
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
     * @ORM\Column(name="username", type="string", length=23, nullable=false)
     */
    private $username;

    /**
     * @ORM\ManyToMany(targetEntity="Group")
     * @ORM\JoinTable(name="user_groups",
     *      joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="group_id", referencedColumnName="id")}
     *      )
     * @var Group[]
     */
    private $groups;

    /**
     * @var string|null
     *
     * @ORM\Column(name="prename", type="string", nullable=true)
     */
    private $prename;

    /**
     * @var string|null
     *
     * @ORM\Column(name="surname", type="string", nullable=true)
     */
    private $surname;

    /**
     * @var int|null
     *
     * @ORM\Column(name="age", type="integer", nullable=true)
     */
    private $age;

    /**
     * @var string|null
     *
     * @ORM\Column(name="phone", type="string", length=40, nullable=true)
     */
    private $phone;

    /**
     * @var string|null
     *
     * @ORM\Column(name="dect", type="string", length=5, nullable=true)
     */
    private $dect;

    /**
     * @var string|null
     *
     * @ORM\Column(name="mobile", type="string", length=40, nullable=true)
     */
    private $mobile;

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
    private $emailShiftinfo = false;

    /**
     * @var string|null
     *
     * @ORM\Column(name="jabber", type="string", length=200, nullable=true)
     */
    private $jabber;

    /**
     * @var string|null
     *
     * @ORM\Column(name="size", type="string", length=4, nullable=true)
     */
    private $size;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(max=4096)
     */
    private $plainPassword;

    /**
     * @var string|null
     *
     * @ORM\Column(name="password", type="string", nullable=true)
     */
    private $password;

    /**
     * @var string|null
     *
     * @ORM\Column(name="password_recovery_token", type="string", nullable=true)
     */
    private $passwordRecoveryToken;

    /**
     * @var bool
     *
     * @ORM\Column(name="arrived", type="boolean", nullable=false)
     */
    private $arrived = false;

    /**
     * @var bool
     *
     * @ORM\Column(name="active", type="boolean", nullable=false)
     */
    private $active = false;

    /**
     * @var bool
     *
     * @ORM\Column(name="force_active", type="boolean", nullable=false)
     */
    private $forceActive = false;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="t_shirt", type="boolean", nullable=false)
     */
    private $tShirt = false;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="color", type="boolean", nullable=true, options={"default"="10"})
     */
    private $color = '10';

    /**
     * @var string
     *
     * @ORM\Column(name="language", type="string", nullable=false, options={"fixed"=true})
     */
    private $language = 'en';

    /**
     * @var string
     *
     * @ORM\Column(name="menu", type="string", length=1, nullable=false, options={"default"="L","fixed"=true})
     */
    private $menu = 'L';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="last_login", type="datetime", nullable=true)
     */
    private $lastLogin;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="create_date", type="datetime", nullable=false)
     */
    private $createDate;

    /**
     * @var string|null
     *
     * @ORM\Column(name="type", type="string", length=30, nullable=true)
     */
    private $type;

    /**
     * @var string|null
     *
     * @ORM\Column(name="comment", type="text", nullable=true)
     */
    private $comment;

    /**
     * @var string
     *
     * @ORM\Column(name="hometown", type="string", length=255, nullable=true)
     */
    private $hometown = '';

    /**
     * @var string
     *
     * @ORM\Column(name="api_key", type="string", nullable=false)
     */
    private $apiKey;

    /**
     * @var int
     *
     * @ORM\Column(name="got_voucher", type="integer", nullable=false)
     */
    private $gotVoucher = false;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="arrival_date", type="datetime", nullable=true)
     */
    private $arrivalDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="planned_arrival_date", type="datetime", nullable=false)
     */
    private $plannedArrivalDate;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="planned_departure_date", type="datetime", nullable=true)
     */
    private $plannedDepartureDate;

    /**
     * @var bool
     *
     * @ORM\Column(name="email_by_human_allowed", type="boolean", nullable=false)
     */
    private $emailByHumanAllowed;

    public function __construct()
    {
        $this->groups = new ArrayCollection();
    }

    /**
     * String representation of object
     * @link http://php.net/manual/en/serializable.serialize.php
     * @return string the string representation of the object or null
     * @since 5.1.0
     */
    public function serialize()
    {
        return serialize([
            $this->id,
            $this->username,
            $this->password,
        ]);
    }

    /**
     * Constructs the object
     * @link http://php.net/manual/en/serializable.unserialize.php
     * @param string $serialized <p>
     * The string representation of the object.
     * </p>
     * @return void
     * @since 5.1.0
     */
    public function unserialize($serialized)
    {
        [
            $this->id,
            $this->username,
            $this->password,
        ] = unserialize($serialized, array('allowed_classes' => false));
    }

    /**
     * Returns the roles granted to the user.
     *
     * <code>
     * public function getRoles()
     * {
     *     return array('ROLE_USER');
     * }
     * </code>
     *
     * Alternatively, the roles might be stored on a ``roles`` property,
     * and populated in any number of different ways when the user object
     * is created.
     *
     * @return (Role|string)[] The user roles
     */
    public function getRoles()
    {
        return array_map(function (Group $group) {
            return $group->getName();
        }, $this->getGroups()->getValues());
    }

    public function hasPermission(string $wantedPermission) {
        foreach ($this->getGroups() as $group) {
            if ($group->hasPermission($wantedPermission)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Returns the salt that was originally used to encode the password.
     *
     * This can return null if the password was not encoded using a salt.
     *
     * @return string|null The salt
     */
    public function getSalt()
    {
        return null;
    }

    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials()
    {
        $this->plainPassword = null;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSurname(): ?string
    {
        return $this->surname;
    }

    public function setSurname(string $surname): self
    {
        $this->surname = $surname;

        return $this;
    }

    public function setUsername(?string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getPrename(): ?string
    {
        return $this->prename;
    }

    public function setPrename(?string $prename): self
    {
        $this->prename = $prename;

        return $this;
    }

    public function getAge(): ?int
    {
        return $this->age;
    }

    public function setAge(?int $age): self
    {
        $this->age = $age;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;

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

    public function getMobile(): ?string
    {
        return $this->mobile;
    }

    public function setMobile(?string $mobile): self
    {
        $this->mobile = $mobile;

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

    public function setPassword(?string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    public function setPlainPassword($plainPassword): void
    {
        $this->plainPassword = $plainPassword;
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

    public function getArrived(): ?bool
    {
        return $this->arrived;
    }

    public function setArrived(bool $arrived): self
    {
        $this->arrived = $arrived;

        return $this;
    }

    public function getActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(bool $active): self
    {
        $this->active = $active;

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

    public function getTShirt(): ?bool
    {
        return $this->tShirt;
    }

    public function setTShirt(bool $tShirt): self
    {
        $this->tShirt = $tShirt;

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

    public function getLanguage(): ?string
    {
        return $this->language;
    }

    public function setLanguage(string $language): self
    {
        $this->language = $language;

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

    public function getLastLogin(): ?\DateTimeInterface
    {
        return $this->lastLogin;
    }

    public function setLastLogin(?\DateTimeInterface $lastLogin): self
    {
        $this->lastLogin = $lastLogin;

        return $this;
    }

    public function getCreateDate(): ?\DateTimeInterface
    {
        return $this->createDate;
    }

    public function setCreateDate(\DateTimeInterface $createDate): self
    {
        $this->createDate = $createDate;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): self
    {
        $this->comment = $comment;

        return $this;
    }

    public function getHometown(): ?string
    {
        return $this->hometown;
    }

    public function setHometown(?string $hometown): self
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

    public function getArrivalDate(): ?\DateTimeInterface
    {
        return $this->arrivalDate;
    }

    public function setArrivalDate(?\DateTimeInterface $arrivalDate): self
    {
        $this->arrivalDate = $arrivalDate;

        return $this;
    }

    public function getPlannedArrivalDate(): ?\DateTimeInterface
    {
        return $this->plannedArrivalDate;
    }

    public function setPlannedArrivalDate(\DateTimeInterface $plannedArrivalDate): self
    {
        $this->plannedArrivalDate = $plannedArrivalDate;

        return $this;
    }

    public function getPlannedDepartureDate(): ?\DateTimeInterface
    {
        return $this->plannedDepartureDate;
    }

    public function setPlannedDepartureDate(?\DateTimeInterface $plannedDepartureDate): self
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

    /**
     * @return Collection|Group[]
     */
    public function getGroups(): Collection
    {
        return $this->groups;
    }

    public function addGroup(Group $group): self
    {
        if (!$this->groups->contains($group)) {
            $this->groups[] = $group;
        }

        return $this;
    }

    public function removeGroup(Group $group): self
    {
        if ($this->groups->contains($group)) {
            $this->groups->removeElement($group);
        }

        return $this;
    }
}
