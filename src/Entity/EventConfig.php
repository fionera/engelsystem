<?php

namespace Engelsystem\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EventConfig
 *
 * @ORM\Table(name="EventConfig")
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
     * @ORM\Column(name="event_name", type="string", length=255, nullable=true)
     */
    private $eventName;

    /**
     * @var int|null
     *
     * @ORM\Column(name="buildup_start_date", type="integer", nullable=true)
     */
    private $buildupStartDate;

    /**
     * @var int|null
     *
     * @ORM\Column(name="event_start_date", type="integer", nullable=true)
     */
    private $eventStartDate;

    /**
     * @var int|null
     *
     * @ORM\Column(name="event_end_date", type="integer", nullable=true)
     */
    private $eventEndDate;

    /**
     * @var int|null
     *
     * @ORM\Column(name="teardown_end_date", type="integer", nullable=true)
     */
    private $teardownEndDate;

    /**
     * @var string|null
     *
     * @ORM\Column(name="event_welcome_msg", type="string", length=255, nullable=true)
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

    public function getBuildupStartDate(): ?int
    {
        return $this->buildupStartDate;
    }

    public function setBuildupStartDate(?int $buildupStartDate): self
    {
        $this->buildupStartDate = $buildupStartDate;

        return $this;
    }

    public function getEventStartDate(): ?int
    {
        return $this->eventStartDate;
    }

    public function setEventStartDate(?int $eventStartDate): self
    {
        $this->eventStartDate = $eventStartDate;

        return $this;
    }

    public function getEventEndDate(): ?int
    {
        return $this->eventEndDate;
    }

    public function setEventEndDate(?int $eventEndDate): self
    {
        $this->eventEndDate = $eventEndDate;

        return $this;
    }

    public function getTeardownEndDate(): ?int
    {
        return $this->teardownEndDate;
    }

    public function setTeardownEndDate(?int $teardownEndDate): self
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
