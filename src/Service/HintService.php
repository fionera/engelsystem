<?php

namespace Engelsystem\Service;

use Doctrine\ORM\EntityManagerInterface;

class HintService
{
    const ADMIN_NEW_QUESTIONS = 'ADMIN_NEW_QUESTIONS';
    const ANGELTYPES_UNCONFIRMED = 'ANGELTYPES_UNCONFIRMED';
    const DEPARTURE_DATE = 'DEPARTURE_DATE';
    const DRIVER_LICENSE_REQUIRED = 'DRIVER_LICENSE_REQUIRED';
    const FREELOADER = 'FREELOADER';
    const ARRIVED = 'ARRIVED';
    const TSHIRT = 'TSHIRT';
    const DECT = 'DECT';

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * HintService constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function addHint(string $hint)
    {
    }
}