<?php

namespace LeanStack\CinetixxClient\Model;

class Event
{
    /**
     * @var int
     */
    protected $eventId;

    /**
     * @var string
     */
    protected $title;

    /**
     * @var Show[]
     */
    protected $shows;

    /**
     * Event constructor.
     * @param string $eventId
     * @param string $title
     */
    public function __construct(string $eventId, $title)
    {
        $this->eventId = intval($eventId);
        $this->title = $title;
        $this->shows = [];
    }

    /**
     * @return int
     */
    public function getEventId()
    {
        return $this->eventId;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return Show[]
     */
    public function getShows()
    {
        return $this->shows;
    }

    /**
     * @param Show $show
     */
    public function addShow(Show $show)
    {
        $this->shows[] = $show;
    }
}