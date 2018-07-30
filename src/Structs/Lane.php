<?php

namespace Engelsystem\Structs;

use Engelsystem\Entity\Room;
use Engelsystem\Entity\Shift;

class Lane
{
    /**
     * @var Shift[]
     */
    private $shifts;

    /**
     * @var \DateTime
     */
    private $lastEnd;

    /**
     * @var Room
     */
    private $room;

    /**
     * Lane constructor.
     * @param array $shifts
     * @param Room $room
     */
    public function __construct(array $shifts, Room $room)
    {
        $this->shifts = $shifts;
        $this->room = $room;
    }

    public function getLastEnd()
    {
        if ($this->lastEnd === null) {
            foreach ($this->shifts as $shift) {
                if ($this->lastEnd === null || $this->lastEnd <= $shift->getEnd()) {
                    $this->lastEnd = $shift->getEnd();
                }
            }
        }

        return $this->lastEnd;
    }

    public function addShift(Shift $shift)
    {
        if ($shift->getEnd() <= $this->lastEnd) {
            $this->lastEnd = $shift->getEnd();
        }

        $this->shifts[] = $shift;
    }

    /**
     * @return Shift[]
     */
    public function getShifts(): array
    {
        return $this->shifts;
    }

    /**
     * @return Room
     */
    public function getRoom(): Room
    {
        return $this->room;
    }

    public function getTicks(): array
    {
        return [
            [
                'tickAmount' => 4
            ]
        ];
    }
}