<?php

namespace LeanStack\CinetixxClient\Message;

/**
 * Class GetEventImages
 * @package LeanStack\CinetixxClient\Message
 */
class GetEventImagesRequest {

	/**
	 * @var integer
	 */
	public $eventId;

    /**
     * GetEventImagesRequest constructor.
     * @param int $eventId
     */
    public function __construct($eventId)
    {
        $this->eventId = $eventId;
    }

}