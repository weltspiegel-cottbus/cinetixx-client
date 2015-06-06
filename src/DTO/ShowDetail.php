<?php

namespace LeanStack\CinetixxClient\DTO;

/**
 * Class ShowDetail
 * @package LeanStack\CinetixxClient\DTO
 */
class ShowDetail {

    /**
     * @var integer
     */
    public $mandatorId;

    /**
     * @var integer
     */
    public $showId;

	/**
	 * @var string
	 */
	public $ShowStatus;

	/**
	 * @var DTOCinemaShort
	 */
	public $CinemaShort;

	/**
	 * @var DTOAuditoriumShort
	 */
	public $AuditoriumShort;

	/**
	 * @var string
	 */
	public $ShowStart;

	/**
	 * @var string
	 */
	public $ShowEnd;

	/**
	 * @var string
	 */
	public $Link;

	/**
	 * @var string
	 */
	public $RestLink;

	/**
	 * @var string
	 */
	public $Event;

	/**
	 * @var string
	 */
	public $StartReservation;

	/**
	 * @var string
	 */
	public $EndReservation;

	/**
	 * @var string
	 */
	public $StartSale;

	/**
	 * @var string
	 */
	public $EndSale;

	/**
	 * @var integer
	 */
	public $CountFreeSeats;

	/**
	 * @var integer
	 */
	public $CountFreeSeatsWheelchair;

	/**
	 * @var integer
	 */
	public $CountFreeSeatsDisabled;
}