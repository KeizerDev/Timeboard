<?php

namespace TimeBoard\Manager;

use TimeBoard\Repository\TimeBoardRepository;

class TimeBoardManager
{
    /**
     * @var TimeBoardRepository
     */
    private $timeBoardRepository;

    /**
     * TimeBoardManager constructor.
     * @param TimeBoardRepository $timeBoardRepository
     */
    public function __construct(TimeBoardRepository $timeBoardRepository)
    {

        $this->timeBoardRepository = $timeBoardRepository;
    }

    /**
     * returns the TimeBoardRepository
     * @return TimeBoardRepository
     */
    public function getTimeBoardRepository()
    {
        return $this->timeBoardRepository;
    }

}