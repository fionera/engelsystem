<?php

namespace Engelsystem\Structs;

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
     * Lane constructor.
     */
    public function __construct(array $shifts)
    {
        $this->shifts = $shifts;
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

    public function getTicks(): array
    {
        return [
            [
                'tickAmount' => 4
            ]
        ];
    }
}