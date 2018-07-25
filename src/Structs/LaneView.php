<?php

namespace Engelsystem\Structs;

use Symfony\Component\VarDumper\VarDumper;

class LaneView
{
    /**
     * @var Lane[]
     */
    private $lanes;
    /**
     * @var \DateTime
     */
    private $startTime;
    /**
     * @var \DateTime
     */
    private $endTime;

    /**
     * LaneView constructor.
     * @param array $lanes
     * @param \DateTime $startTime
     * @param \DateTime $endTime
     */
    public function __construct(array $lanes, \DateTime $startTime, \DateTime $endTime)
    {
        $this->lanes = $lanes;
        $this->startTime = $startTime;
        $this->endTime = $endTime;
    }

    public function get()
    {
        $lanes = [];

        foreach ($this->lanes as $lane) {
            $currentTime = $this->startTime;

            $laneEntries = [];
            $shift = null;
            foreach ($lane->getShifts() as $shift) {
                if ($currentTime < $shift->getStart()) {
                    $laneEntries[] = [
                        'ticks' => $this->getTicks($currentTime, $shift->getStart())
                    ];
                }

                $laneEntries[] = $shift;
                $currentTime = $shift->getEnd();
            }

            if ($shift !== null && $shift->getEnd() < $this->endTime) {
                $laneEntries[] = [
                    'ticks' => $this->getTicks($shift->getEnd(), $this->endTime)
                ];
            }

            $lanes[] = $laneEntries;
        }

        return $lanes;
    }

    private function getTicks(\DateTime $endOfPreviousShift, \DateTime $beginOfNextShift)
    {
        $diff = $endOfPreviousShift->diff($beginOfNextShift);

        $amount = $diff->h * 4;
        $amount += $diff->i / 15;

        $ticks = [];
        for ($i = 0; $i < $amount; $i++) {
            $time = clone $endOfPreviousShift;
            $time->add(new \DateInterval('PT' . $i * 15 . 'M'));

            $ticks[] = [
                'isHour' => $time->format('i') === '00'
            ];
        }

        return $ticks;
    }

    public function getShiftHours()
    {
        $diff = $this->endTime->diff($this->startTime);

        $shiftHours = [];
        for ($h = 0; $h <=  $diff->h; $h++) {
            $currentStartTime = clone $this->startTime;

            $shiftHours[] = [
                'date' => $currentStartTime->add(new \DateInterval('PT' . $h . 'H')),
                'ticks' => 2
            ];
        }

        return $shiftHours;
    }
}