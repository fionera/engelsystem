<?php

namespace Engelsystem\Service;


use Engelsystem\Entity\Shift;
use Engelsystem\Structs\Lane;
use Engelsystem\Structs\LaneView;
use Symfony\Component\VarDumper\VarDumper;

class LaneService
{
    /**
     * @var StructService
     */
    private $structService;

    /**
     * LaneService constructor.
     * @param StructService $structService
     */
    public function __construct(StructService $structService)
    {
        $this->structService = $structService;
    }

    /**
     * @param Lane[] $lanes
     * @param Shift $shift
     */
    public function addShift(array &$lanes, Shift $shift)
    {
        foreach ($lanes as $lane) {
            if ($lane->getLastEnd() <= $shift->getStart() && $shift->getRoom() === $lane->getRoom()) {
                $lane->addShift($shift);
                return;
            }
        }

        $lane = new Lane([$shift], $shift->getRoom());

        $lanes[] = $lane;
    }

    public function createMultiDayLaneView(array $shifts)
    {
        $days = [];

        /** @var Shift $shift */
        foreach ($shifts as $shift) {
            $days[$shift->getStart()->format('d-m-Y')][] = $shift;
        }

        foreach ($days as &$day) {
            $day =  $this->structService->getLaneViewStruct($this->createLaneView($day));
        }
        unset($day);

        return $days;
    }

    public function createLaneView(array $shifts)
    {
        uasort($shifts, function (Shift $shiftA, Shift $shiftB) {
            return $shiftA->getStart() > $shiftB->getStart();
        });

        $lanes = [];
        $startTime = null;
        $endTime = null;

        foreach ($shifts as $shift) {
            if ($startTime === null || $startTime > $shift->getStart()) {
                $startTime = $shift->getStart();
            }

            if ($endTime === null || $endTime < $shift->getEnd()) {
                $endTime = $shift->getEnd();
            }

            $this->addShift($lanes, $shift);
        }


        return new LaneView($lanes, $startTime, $endTime);
    }
}