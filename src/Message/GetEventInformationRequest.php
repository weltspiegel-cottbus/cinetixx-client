<?php

namespace LeanStack\CinetixxClient\Message;

/**
 * Class GetEventInformation
 * @package LeanStack\CinetixxClient\Message
 */
class GetEventInformationRequest {

	/**
	 * @var integer
	 */
	public $eventId;

    /**
     * GetEventInformation constructor.
     * @param int $eventId
     */
    public function __construct($eventId)
    {
        $this->eventId = $eventId;
    }

}