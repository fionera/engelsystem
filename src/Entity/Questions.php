<?php

namespace Engelsystem\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Questions
 *
 * @ORM\Table(name="Questions", indexes={@ORM\Index(name="UID", columns={"UID"}), @ORM\Index(name="AID", columns={"AID"})})
 * @ORM\Entity
 */
class Questions
{
    /**
     * @var int
     *
     * @ORM\Column(name="QID", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $qid;

    /**
     * @var string
     *
     * @ORM\Column(name="Question", type="text", length=65535, nullable=false)
     */
    private $question;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Answer", type="text", length=65535, nullable=true)
     */
    private $answer;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="UID", referencedColumnName="UID")
     * })
     */
    private $uid;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="AID", referencedColumnName="UID")
     * })
     */
    private $aid;

    public function getQid(): ?int
    {
        return $this->qid;
    }

    public function getQuestion(): ?string
    {
        return $this->question;
    }

    public function setQuestion(string $question): self
    {
        $this->question = $question;

        return $this;
    }

    public function getAnswer(): ?string
    {
        return $this->answer;
    }

    public function setAnswer(?string $answer): self
    {
        $this->answer = $answer;

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

    public function getAid(): ?User
    {
        return $this->aid;
    }

    public function setAid(?User $aid): self
    {
        $this->aid = $aid;

        return $this;
    }


}
