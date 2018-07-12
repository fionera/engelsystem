<?php

namespace Engelsystem\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * News
 *
 * @ORM\Table(name="News", indexes={@ORM\Index(name="UID", columns={"UID"})})
 * @ORM\Entity
 */
class News
{
    /**
     * @var int
     *
     * @ORM\Column(name="ID", type="integer", nullable=false)
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
     * @ORM\Column(name="Betreff", type="string", length=150, nullable=false)
     */
    private $betreff = '';

    /**
     * @var string
     *
     * @ORM\Column(name="Text", type="text", length=65535, nullable=false)
     */
    private $text;

    /**
     * @var bool
     *
     * @ORM\Column(name="Treffen", type="boolean", nullable=false)
     */
    private $treffen = '0';

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

    public function getDatum(): ?int
    {
        return $this->datum;
    }

    public function setDatum(int $datum): self
    {
        $this->datum = $datum;

        return $this;
    }

    public function getBetreff(): ?string
    {
        return $this->betreff;
    }

    public function setBetreff(string $betreff): self
    {
        $this->betreff = $betreff;

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

    public function getTreffen(): ?bool
    {
        return $this->treffen;
    }

    public function setTreffen(bool $treffen): self
    {
        $this->treffen = $treffen;

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
