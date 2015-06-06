<?php

namespace LeanStack\CinetixxClient\Message;

/**
 * Class GetShowsForEvent
 * @package LeanStack\CinetixxClient\Message
 */
class GetShowsForEventRequest {

    /**
	 * @var integer
	 */
	public $eventId;

	/**
	 * @var string
	 */
	public $dateFrom;

	/**
	 * @var string
	 */
	public $dateUntil;

    /**
     * GetShowsForEventRequest constructor.
     * @param int $eventId
     * @param \DateTime $dateFrom
     * @param \DateTime $dateUntil
     */
    public function __construct($eventId, \DateTime $dateFrom, \DateTime $dateUntil)
    {
        $this->eventId = $eventId;
        $this->dateFrom = $dateFrom->format(\DateTime::W3C);
        $this->dateUntil = $dateUntil->format(\DateTime::W3C);
    }

}