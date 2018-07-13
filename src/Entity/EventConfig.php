<?php

namespace Engelsystem\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EventConfig
 *
 * @ORM\Entity
 */
class EventConfig
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
     * @var string|null
     *
     * @ORM\Column(name="event_name", type="string", nullable=true)
     */
    private $eventName;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="buildup_start_date", type="datetime", nullable=true)
     */
    private $buildupStartDate;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="event_start_date", type="datetime", nullable=true)
     */
    private $eventStartDate;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="event_end_date", type="datetime", nullable=true)
     */
    private $eventEndDate;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="teardown_end_date", type="datetime", nullable=true)
     */
    private $teardownEndDate;

    /**
     * @var string|null
     *
     * @ORM\Column(name="event_welcome_msg", type="string", nullable=true)
     */
    private $eventWelcomeMsg;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEventName(): ?string
    {
        return $this->eventName;
    }

    public function setEventName(?string $eventName): self
    {
        $this->eventName = $eventName;

        return $this;
    }

    public function getBuildupStartDate(): ?\DateTimeInterface
    {
        return $this->buildupStartDate;
    }

    public function setBuildupStartDate(?\DateTimeInterface $buildupStartDate): self
    {
        $this->buildupStartDate = $buildupStartDate;

        return $this;
    }

    public function getEventStartDate(): ?\DateTimeInterface
    {
        return $this->eventStartDate;
    }

    public function setEventStartDate(?\DateTimeInterface $eventStartDate): self
    {
        $this->eventStartDate = $eventStartDate;

        return $this;
    }

    public function getEventEndDate(): ?\DateTimeInterface
    {
        return $this->eventEndDate;
    }

    public function setEventEndDate(?\DateTimeInterface $eventEndDate): self
    {
        $this->eventEndDate = $eventEndDate;

        return $this;
    }

    public function getTeardownEndDate(): ?\DateTimeInterface
    {
        return $this->teardownEndDate;
    }

    public function setTeardownEndDate(?\DateTimeInterface $teardownEndDate): self
    {
        $this->teardownEndDate = $teardownEndDate;

        return $this;
    }

    public function getEventWelcomeMsg(): ?string
    {
        return $this->eventWelcomeMsg;
    }

    public function setEventWelcomeMsg(?string $eventWelcomeMsg): self
    {
        $this->eventWelcomeMsg = $eventWelcomeMsg;

        return $this;
    }
}
