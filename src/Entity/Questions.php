<?php

namespace Engelsystem\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Questions
 *
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
     * @ORM\Column(name="Question", type="text", nullable=false)
     */
    private $question;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Answer", type="text", nullable=true)
     */
    private $answer;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ask_user_id", referencedColumnName="id")
     * })
     */
    private $ask_user;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="answer_user_id", referencedColumnName="id")
     * })
     */
    private $answer_user;

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

    public function getAskUser(): ?User
    {
        return $this->ask_user;
    }

    public function setAskUser(?User $ask_user): self
    {
        $this->ask_user = $ask_user;

        return $this;
    }

    public function getAnswerUser(): ?User
    {
        return $this->answer_user;
    }

    public function setAnswerUser(?User $answer_user): self
    {
        $this->answer_user = $answer_user;

        return $this;
    }

}
