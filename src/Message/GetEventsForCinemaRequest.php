<?php

namespace LeanStack\CinetixxClient\Message;

/**
 * Class GetEventsForCinema
 * @package LeanStack\CinetixxClient\Message
 */
class GetEventsForCinemaRequest {

	/**
	 * @var integer
	 */
	public $cinemaId;

	/**
	 * @var string
	 */
	public $dateFrom;

	/**
	 * @var string
	 */
	public $dateUntil;

    /**
     * GetEventsForCinema constructor.
     * @param int $cinemaId
     * @param \DateTime $dateFrom
     * @param \DateTime $dateUntil
     */
    public function __construct($cinemaId, \DateTime $dateFrom, \DateTime $dateUntil)
    {
        $this->cinemaId = $cinemaId;
        $this->dateFrom = $dateFrom->format(\DateTime::W3C);
        $this->dateUntil = $dateUntil->format(\DateTime::W3C);
    }

}