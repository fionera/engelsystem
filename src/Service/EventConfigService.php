<?php

namespace Engelsystem\Service;

use Doctrine\ORM\EntityManagerInterface;

class EventConfigService
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * EventConfigService constructor.
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getEventDays()
    {
        $startDate = new \DateTime('now');
        $endDate = new \DateTime('90 days');

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