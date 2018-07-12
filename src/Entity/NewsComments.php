<?php

namespace Engelsystem\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * NewsComments
 *
 * @ORM\Table(name="NewsComments", indexes={@ORM\Index(name="Refid", columns={"Refid"}), @ORM\Index(name="UID", columns={"UID"})})
 * @ORM\Entity
 */
class NewsComments
{
    /**
     * @var int
     *
     * @ORM\Column(name="ID", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="Datum", type="datetime", nullable=false, options={"default"="1000-01-01 00:00:00"})
     */
    private $datum = '1000-01-01 00:00:00';

    /**
     * @var string
     *
     * @ORM\Column(name="Text", type="text", length=65535, nullable=false)
     */
    private $text;

    /**
     * @var News
     *
     * @ORM\ManyToOne(targetEntity="News")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Refid", referencedColumnName="ID")
     * })
     */
    private $refid;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="UID", referencedColumnName="UID")
     * })
     */
    private $uid;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDatum(): ?\DateTimeInterface
    {
        return $this->datum;
    }

    public function setDatum(\DateTimeInterface $datum): self
    {
        $this->datum = $datum;

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

    public function getRefid(): ?News
    {
        return $this->refid;
    }

    public function setRefid(?News $refid): self
    {
        $this->refid = $refid;

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
