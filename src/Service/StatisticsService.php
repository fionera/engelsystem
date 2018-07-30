<?php

namespace Engelsystem\Service;


use Doctrine\ORM\EntityManagerInterface;
use Engelsystem\Entity\ShiftEntry;
use Engelsystem\Entity\User;

class StatisticsService
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * StatisticsService constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getArrived()
    {
        $users = $this->entityManager->getRepository(User::class)->findBy(['arrived' => true]);

        return \count($users);
    }

    public function getActive()
    {
        $users = $this->entityManager->getRepository(User::class)->findBy(['active' => true]);

        return \count($users);
    }

    public function getForceActive()
    {
        $users = $this->entityManager->getRepository(User::class)->findBy(['forceActive' => true]);

        return \count($users);
    }

    public function getTshirt()
    {
        $users = $this->entityManager->getRepository(User::class)->findBy(['tShirt' => true]);

        return \count($users);
    }

    public function getVouchers()
    {
        $users = $this->entityManager->getRepository(User::class)->findAll();

        $vouchers = 0;

        foreach ($users as $user) {
            $vouchers += $user->getVoucher();
        }

        return $vouchers;
    }

    public function getFreeloads()
    {
        $shifts = $this->entityManager->getRepository(ShiftEntry::class)->findBy(['freeloaded' => true]);

        return \count($shifts);

    }

    public function getStaticsStruct()
    {
        return [
            'arrived' => $this->getArrived(),
            'vouchers' => $this->getVouchers(),
            'freeloads' => $this->getFreeloads(),
            'active' => $this->getActive(),
            'forceActive' => $this->getForceActive(),
            'tshirts' => $this->getTshirt(),
        ];
    }
}