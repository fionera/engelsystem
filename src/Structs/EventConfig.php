<?php

namespace Engelsystem\Structs;

class EventConfig
{
    private $config = [
        'eventName' => null,
        'buildupStartDate' => null,
        'eventStartDate' => null,
        'eventEndDate' => null,
        'teardownEndDate' => null,
        'eventWelcomeMsg' => null,
    ];

    public function getEventName(): ?string
    {
        return $this->config['eventName'] ?? '';
    }

    public function setEventName(?string $eventName): self
    {
        $this->config['eventName'] = $eventName;

        return $this;
    }

    public function getBuildupStartDate(): ?\DateTimeInterface
    {
        if (\is_string($this->config['buildupStartDate'])) {
            $this->config['buildupStartDate'] = unserialize($this->config['buildupStartDate'], ['allowed_classes' => [\DateTime::class]]);
        }

        return $this->config['buildupStartDate'];
    }

    public function setBuildupStartDate(?\DateTimeInterface $buildupStartDate): self
    {
        $this->config['buildupStartDate'] = $buildupStartDate;

        return $this;
    }

    public function getEventStartDate(): ?\DateTimeInterface
    {
        if (\is_string($this->config['eventStartDate'])) {
            $this->config['eventStartDate'] = unserialize($this->config['eventStartDate'], ['allowed_classes' => [\DateTime::class]]);
        }

        return $this->config['eventStartDate'];
    }

    public function setEventStartDate(?\DateTimeInterface $eventStartDate): self
    {
        $this->config['eventStartDate'] = $eventStartDate;

        return $this;
    }

    public function getEventEndDate(): ?\DateTimeInterface
    {
        if (\is_string($this->config['eventEndDate'])) {
            $this->config['eventEndDate'] = unserialize($this->config['eventEndDate'], ['allowed_classes' => [\DateTime::class]]);
        }

        return $this->config['eventEndDate'];
    }

    public function setEventEndDate(?\DateTimeInterface $eventEndDate): self
    {
        $this->config['eventEndDate'] = $eventEndDate;

        return $this;
    }

    public function getTeardownEndDate(): ?\DateTimeInterface
    {
        if (\is_string($this->config['teardownEndDate'])) {
            $this->config['teardownEndDate'] = unserialize($this->config['teardownEndDate'], ['allowed_classes' => [\DateTime::class]]);
        }

        return $this->config['teardownEndDate'];
    }

    public function setTeardownEndDate(?\DateTimeInterface $teardownEndDate): self
    {
        $this->config['teardownEndDate'] = $teardownEndDate;

        return $this;
    }

    public function getEventWelcomeMsg(): ?string
    {
        return $this->config['eventWelcomeMsg'];
    }

    public function setEventWelcomeMsg(?string $eventWelcomeMsg): self
    {
        $this->config['eventWelcomeMsg'] = $eventWelcomeMsg;

        return $this;
    }

    public function set(string $key, $value)
    {
        $this->config[$key] = $value;
    }

    public function getConfig(): array
    {
        return $this->config;
    }
}
