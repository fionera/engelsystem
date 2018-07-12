<?php

namespace Engelsystem\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Messages
 *
 * @ORM\Table(name="Messages", indexes={@ORM\Index(name="Datum", columns={"Datum"}), @ORM\Index(name="SUID", columns={"SUID"}), @ORM\Index(name="RUID", columns={"RUID"})})
 * @ORM\Entity
 */
class Messages
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
     * @var int
     *
     * @ORM\Column(name="Datum", type="integer", nullable=false)
     */
    private $datum;

    /**
     * @var string
     *
     * @ORM\Column(name="isRead", type="string", length=1, nullable=false, options={"default"="N","fixed"=true})
     */
    private $isread = 'N';

    /**
     * @var string
     *
     * @ORM\Column(name="Text", type="text", length=65535, nullable=false)
     */
    private $text;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="SUID", referencedColumnName="UID")
     * })
     */
    private $suid;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="RUID", referencedColumnName="UID")
     * })
     */
    private $ruid;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDatum(): ?int
    {
        return $this->datum;
    }

    public function setDatum(int $datum): self
    {
        $this->datum = $datum;

        return $this;
    }

    public function getIsread(): ?string
    {
        return $this->isread;
    }

    public function setIsread(string $isread): self
    {
        $this->isread = $isread;

        return $this;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(string $text): self
    {
        $this->text = $text;

        return $this;
    }

    public function getSuid(): ?User
    {
        return $this->suid;
    }

    public function setSuid(?User $suid): self
    {
        $this->suid = $suid;

        return $this;
    }

    public function getRuid(): ?User
    {
        return $this->ruid;
    }

    public function setRuid(?User $ruid): self
    {
        $this->ruid = $ruid;

        return $this;
    }


}
