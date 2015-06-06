<?php

namespace LeanStack\CinetixxClient\DTO;

/**
 * Class DTOEventInformation
 * @package LeanStack\CinetixxClient\DTO
 */
class EventInformation {

	/**
	 * @var string
	 */
	public $Name;

	/**
	 * @var string
	 */
	public $ShortName;

	/**
	 * @var string
	 */
	public $Region;

	/**
	 * @var string
	 */
	public $Category1;

	/**
	 * @var string
	 */
	public $Category2;

	/**
	 * @var string
	 */
	public $Category3;

	/**
	 * @var string
	 */
	public $Language;

	/**
	 * @var string
	 */
	public $VideoType;

	/**
	 * @var string
	 */
	public $AudioType;

	/**
	 * @var string
	 */
	public $VersionType;

	/**
	 * @var string
	 */
	public $DateFrom;

	/**
	 * @var string
	 */
	public $DateUntil;

	/**
	 * @var integer
	 */
	public $Duration;

	/**
	 * @var number
	 */
	public $SalesTax;

	/**
	 * @var string
	 */
	public $Playweek;

	/**
	 * @var boolean
	 */
	public $Flag3D;

	/**
	 * @var boolean
	 */
	public $FlagDigital;

	/**
	 * @var string
	 */
	public $Rating;

	/**
	 * @var TypedText[]
	 */
	public $TextList;

	/**
	 * @var string
	 */
	public $LinkTrailer;

	/**
	 * @var integer[]
	 */
	public $MovieIds;

	/**
	 * @var string
	 */
	public $XrefReleaseNo;

	/**
	 * @var string
	 */
	public $XrefTitelNo;

	/**
	 * @var string
	 */
	public $EdiNr;

}