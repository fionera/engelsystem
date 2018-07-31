<?php

namespace Engelsystem\Service;

use Doctrine\ORM\EntityManagerInterface;
use Engelsystem\Entity\Config;
use Engelsystem\Structs\EventConfig;

class EventConfigService
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    private $eventConfig;

    /**
     * EventConfigService constructor.
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getEventConfig(): EventConfig
    {
        if ($this->eventConfig !== null) {
            return $this->eventConfig;
        }

        $eventConfig = new EventConfig();

        $configList = $this->entityManager->getRepository(Config::class)->findAll();

        /** @var Config $config */
        foreach ($configList as $config) {
            $eventConfig->set($config->getKey(), $config->getValue());
        }

        $this->eventConfig = $eventConfig;

        return $eventConfig;
    }

    public function saveEventConfig(?EventConfig $eventConfig = null)
    {
        if ($eventConfig === null) {
            $eventConfig = $this->getEventConfig();
        }

        $configList = $this->entityManager->getRepository(Config::class)->findAll();

        /** @var Config[] $sorted */
        $sorted = [];
        /** @var Config $config */
        foreach ($configList as $config) {
            $sorted[$config->getKey()] = $config;
        }

        foreach ($eventConfig->getConfig() as $key => $value) {
            if ($value !== null && !\is_string($value)) {
                $value = serialize($value);
            }

            if (isset($sorted[$key]) && $sorted[$key] !== null) {
                $sorted[$key]->setValue($value);
            } else {
                $sorted[$key] = new Config($key, $value);
            }

            $this->entityManager->persist($sorted[$key]);
        }
        $this->entityManager->flush();
    }

    public function getEventDays()
    {
        $eventConfig = $this->getEventConfig();

        $startDate = $eventConfig->getEventStartDate();
        $endDate = $eventConfig->getEventEndDate();

        if ($startDate === null || $endDate === null) {
            return [];
        }

        $diff = $startDate->diff($endDate);

        $days = [];
        for ($i = 0; $i < $diff->days; $i++) {
            /** @var \DateTime $date */
            $date = clone $startDate;
            $days[] = $date->add(new \DateInterval('P' . $i . 'D'))->format('Y-m-d');
        }

        return $days;
    }
}