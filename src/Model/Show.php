<?php

namespace LeanStack\CinetixxClient\Model;

class Show
{
    /**
     * @var \DateTime
     */
    protected $date;

    /**
     * Show constructor.
     * @param \DateTime $date
     */
    public function __construct(\DateTime $date)
    {
        $this->date = $date;
    }

    /**
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }
}