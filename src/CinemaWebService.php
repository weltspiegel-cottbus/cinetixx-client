<?php

namespace LeanStack\CinetixxClient;

use LeanStack\CinetixxClient\Auth\Token;
use LeanStack\CinetixxClient\DTO\Cinema;
use LeanStack\CinetixxClient\DTO\Event;
use LeanStack\CinetixxClient\DTO\ShowDetail;
use LeanStack\CinetixxClient\Message\GetEventsForCinemaRequest;
use LeanStack\CinetixxClient\Message\GetEventsForCinemaResponse;
use LeanStack\CinetixxClient\Message\GetMandatorCinemas;
use LeanStack\CinetixxClient\Message\GetMandatorCinemasResponse;
use LeanStack\CinetixxClient\Message\GetShowsForEventRequest;

/**
 * Class CinemaWebService
 * @package LeanStack\CinetixxClient
 */
class CinemaWebService extends \SoapClient {

	/** WSDL location for this service */
	const WSDL = "https://service.cinetixx.de/CinemaWebService.asmx?WSDL";

	/** Standard namespace for this service */
	const NS = "https://webservice.cinetixx.de";

	/**
	 * Default class map for wsdl=>php
     * @var array
	 */
	private static $classmap = [
        "DTOEventShort" => Event::class,
        "DTOShowDetail" => ShowDetail::class,
        /*
               "GetMandatorCinemas" => GetMandatorCinemas::class,
               "GetMandatorCinemasResponse" => GetMandatorCinemasResponse::class,
               "DTOCinemaExtended" => Cinema::class,
                "DTOMandatorCinemas" => "DTOMandatorCinemas",
                "DTOAuditoriumShort" => "DTOAuditoriumShort",
                "DTOImage" => "DTOImage",
                "AuthenticationSoapHeader" => "AuthenticationSoapHeader",
                "GetMandatorVoucherTypes" => "GetMandatorVoucherTypes",
                "GetMandatorVoucherTypesResponse" => "GetMandatorVoucherTypesResponse",
                "DTORVoucherType" => "DTORVoucherType",
                "GetMandatorProducts" => "GetMandatorProducts",
                "GetMandatorProductsResponse" => "GetMandatorProductsResponse",
                "DTORGood" => "DTORGood",
                "GoodType" => "GoodType",
                "GetAuditoriumInformation" => "GetAuditoriumInformation",
                "GetAuditoriumInformationResponse" => "GetAuditoriumInformationResponse",
                "DTOAuditoriumInformation" => "DTOAuditoriumInformation",
                "DTOCinemaShort" => "DTOCinemaShort",
                "DTOCinemaAddress" => "DTOCinemaAddress",
                "DTOCityShort" => "DTOCityShort",
                "DTOSeatConfiguration" => "DTOSeatConfiguration",
                "GetAuditoriumsForCinema" => "GetAuditoriumsForCinema",
                "GetAuditoriumsForCinemaResponse" => "GetAuditoriumsForCinemaResponse",
                "DTOAuditoriumInformationList" => "DTOAuditoriumInformationList",
                "DTOEventsForCinema" => "DTOEventsForCinema",
                "GetEventInformation" => "GetEventInformation",
                "GetEventInformationResponse" => "GetEventInformationResponse",
                "DTOEventInformation" => "DTOEventInformation",
                "DTOTypedText" => "DTOTypedText",
                "GetEventImages" => "GetEventImages",
                "GetEventImagesResponse" => "GetEventImagesResponse",
                "DTOEventImages" => "DTOEventImages",
                "GetShowsForEvent" => "GetShowsForEvent",
                "GetShowsForEventResponse" => "GetShowsForEventResponse",
                "DTOEventShows" => "DTOEventShows",
                "GetShowInformation" => "GetShowInformation",
                "GetShowInformationResponse" => "GetShowInformationResponse",
                "DTORShow" => "DTORShow",
                "DTORShowStatus" => "DTORShowStatus",
                "DTORCinema" => "DTORCinema",
                "DTORCity" => "DTORCity",
                "DTORResidence" => "DTORResidence",
                "DTORPhone" => "DTORPhone",
                "DTORImage" => "DTORImage",
                "DTORAuditorium" => "DTORAuditorium",
                "DTORSeatConfiguration" => "DTORSeatConfiguration",
                "DTORTicketPrice" => "DTORTicketPrice",
                "DTORResultInformation" => "DTORResultInformation",
                "GetSectorsForShow" => "GetSectorsForShow",
                "GetSectorsForShowResponse" => "GetSectorsForShowResponse",
                "DTOShowSector" => "DTOShowSector",
                "DTOSector" => "DTOSector",
                "GetSeatsForSector" => "GetSeatsForSector",
                "GetSeatsForSectorResponse" => "GetSeatsForSectorResponse",
                "DTOShowSeatInformation" => "DTOShowSeatInformation",
                "DTOSeatdefinition" => "DTOSeatdefinition",
                "DTOSectorelement" => "DTOSectorelement",
                "DTOPriceArea" => "DTOPriceArea",
                "GetShowSeatStatus" => "GetShowSeatStatus",
                "GetShowSeatStatusResponse" => "GetShowSeatStatusResponse",
                "DTOShowSeatStatus" => "DTOShowSeatStatus",
                "DTOSeatShort" => "DTOSeatShort",
                "GetShowPriceConfiguration" => "GetShowPriceConfiguration",
                "GetShowPriceConfigurationResponse" => "GetShowPriceConfigurationResponse",
                "GetShowsForCinema" => "GetShowsForCinema",
                "GetShowsForCinemaResponse" => "GetShowsForCinemaResponse",
                "DTOShowsForCinema" => "DTOShowsForCinema",
                "DTOShowInfo" => "DTOShowInfo",
                "GetMovieInformation" => "GetMovieInformation",
                "GetMovieInformationResponse" => "GetMovieInformationResponse",
                "DTOREvent" => "DTOREvent",
                "DTORMovie" => "DTORMovie",
                "DTORTypedText" => "DTORTypedText",
                "DTORCast" => "DTORCast",
                */
    ];

    /**
     * Constructor using auth token and debug mode setting
     * @param Token $authToken
     * @param boolean $debug
     */
	public function __construct(Token $authToken, $debug = false) {

		$options = [];

		if( $debug === true ) {
			$options['exceptions'] = true;
			$options['trace'] = true;
		}

		// Build the class map
		foreach(self::$classmap as $wsdlClassName => $phpClassName) {
            $options['classmap'][$wsdlClassName] = $phpClassName;
		}

		parent::__construct(self::WSDL, $options);

		$this->__setSoapHeaders(new \SoapHeader(self::NS,"AuthenticationSoapHeader",$authToken));
	}

    /**
     * Get Events for given cinema id
     *
     * @param $cinemaId
     * @param \DateTime $dateFrom
     * @param \DateTime $dateUntil
     * @return Event[]
     */
    public function GetEventsForCinema($cinemaId, \DateTime $dateFrom, \DateTime $dateUntil) {

        $args = new GetEventsForCinemaRequest($cinemaId, $dateFrom, $dateUntil);
        $response = $this->__soapCall("GetEventsForCinema",[$args]);

        return $response->GetEventsForCinemaResult->Events->DTOEventShort;
    }

    /**
     * Get Shows for given event id
     *
     * @param $eventId
     * @param \DateTime $dateFrom
     * @param \DateTime $dateUntil
     * @return ShowDetail[]
     */
    public function GetShowsForEvent($eventId, \DateTime $dateFrom, \DateTime $dateUntil) {

        $args = new GetShowsForEventRequest($eventId, $dateFrom, $dateUntil);
        $response = $this->__soapCall("GetShowsForEvent", [$args]);

        /** @var ShowDetail[] $shows */
        $shows = $response->GetShowsForEventResult->Shows->DTOShowDetail;

        // Single show?
        if( !is_array($shows))
            $shows = [$shows];

        // GetShowsForEvent SOAP action get all reservable shows, not only the current screened shows
        $screenedShows = [];

        foreach($shows as $show) {
            $showStart = new \DateTime($show->ShowStart);
            if( $showStart > $dateFrom && $showStart < $dateUntil)
                $screenedShows[] = $shows;
        }
        return $screenedShows;
    }


    public function GetShowsForCinema($cinemaId, \DateTime $dateFrom, \DateTime $dateUntil) {

		return $this->__soapCall("GetShowsForCinema", [
            $cinemaId,
            $dateFrom->format(\DateTime::W3C),
            $dateUntil->format(\DateTime::W3C)
        ]);
	}

	/**
     * Checks if an argument list matches against a valid argument type list
     * @param array $arguments The argument list to check
     * @param array $validParameters A list of valid argument types
     * @return boolean true if arguments match against validParameters
     * @throws \Exception invalid function signature message
     */
    public function _checkArguments($arguments, $validParameters) {
        $variables = "";
        foreach ($arguments as $arg) {
            $type = gettype($arg);
            if ($type == "object") {
                $type = get_class($arg);
            }
            $variables .= "(".$type.")";
        }
        if (!in_array($variables, $validParameters)) {
            throw new \Exception("Invalid parameter types: ".str_replace(")(", ", ", $variables));
        }
        return true;
    }

    /**
     * Returns the mandator's cinemas
     * @return Cinema
     */
	public function GetMandatorCinemas() {

        $args = func_get_args();
        $result = $this->__soapCall("GetMandatorCinemas", $args);

        // TODO: return array
        /** @var Cinema $cinema */
        $cinema = $result->GetMandatorCinemasResult->Cinemas->DTOCinemaExtended;
		return $cinema;
	}


	/**
	 * Service Call: GetMandatorVoucherTypes
	 * Parameter options:
	 * (GetMandatorVoucherTypes) parameters
	 * (GetMandatorVoucherTypes) parameters
	 * @param mixed,... See function description for parameter options
	 * @return GetMandatorVoucherTypesResponse
	 * @throws Exception invalid function signature message
	 */
	public function GetMandatorVoucherTypes($mixed = null) {
		$validParameters = array(
			"(GetMandatorVoucherTypes)",
			"(GetMandatorVoucherTypes)",
		);
		$args = func_get_args();
		$this->_checkArguments($args, $validParameters);
		return $this->__soapCall("GetMandatorVoucherTypes", $args);
	}


	/**
	 * Service Call: GetMandatorProducts
	 * Parameter options:
	 * (GetMandatorProducts) parameters
	 * (GetMandatorProducts) parameters
	 * @param mixed,... See function description for parameter options
	 * @return GetMandatorProductsResponse
	 * @throws Exception invalid function signature message
	 */
	public function GetMandatorProducts($mixed = null) {
		$validParameters = array(
			"(GetMandatorProducts)",
			"(GetMandatorProducts)",
		);
		$args = func_get_args();
		$this->_checkArguments($args, $validParameters);
		return $this->__soapCall("GetMandatorProducts", $args);
	}


	/**
	 * Service Call: GetAuditoriumInformation
	 * Parameter options:
	 * (GetAuditoriumInformation) parameters
	 * (GetAuditoriumInformation) parameters
	 * @param mixed,... See function description for parameter options
	 * @return GetAuditoriumInformationResponse
	 * @throws Exception invalid function signature message
	 */
	public function GetAuditoriumInformation($mixed = null) {
		$validParameters = array(
			"(GetAuditoriumInformation)",
			"(GetAuditoriumInformation)",
		);
		$args = func_get_args();
		$this->_checkArguments($args, $validParameters);
		return $this->__soapCall("GetAuditoriumInformation", $args);
	}


	/**
	 * Service Call: GetAuditoriumsForCinema
	 * Parameter options:
	 * (GetAuditoriumsForCinema) parameters
	 * (GetAuditoriumsForCinema) parameters
	 * @param mixed,... See function description for parameter options
	 * @return GetAuditoriumsForCinemaResponse
	 * @throws Exception invalid function signature message
	 */
	public function GetAuditoriumsForCinema($mixed = null) {
		$validParameters = array(
			"(GetAuditoriumsForCinema)",
			"(GetAuditoriumsForCinema)",
		);
		$args = func_get_args();
		$this->_checkArguments($args, $validParameters);
		return $this->__soapCall("GetAuditoriumsForCinema", $args);
	}


	/**
	 * Service Call: GetEventInformation
	 * Parameter options:
	 * (GetEventInformation) parameters
	 * (GetEventInformation) parameters
	 * @param mixed,... See function description for parameter options
	 * @return GetEventInformationResponse
	 * @throws Exception invalid function signature message
	 */
	public function GetEventInformation($mixed = null) {
		$validParameters = array(
			"(GetEventInformation)",
			"(GetEventInformation)",
		);
		$args = func_get_args();
		$this->_checkArguments($args, $validParameters);
		return $this->__soapCall("GetEventInformation", $args);
	}


	/**
	 * Service Call: GetEventImages
	 * Parameter options:
	 * (GetEventImages) parameters
	 * (GetEventImages) parameters
	 * @param mixed,... See function description for parameter options
	 * @return GetEventImagesResponse
	 * @throws Exception invalid function signature message
	 */
	public function GetEventImages($mixed = null) {
		$validParameters = array(
			"(GetEventImages)",
			"(GetEventImages)",
		);
		$args = func_get_args();
		$this->_checkArguments($args, $validParameters);
		return $this->__soapCall("GetEventImages", $args);
	}



	/**
	 * Service Call: GetShowInformation
	 * Parameter options:
	 * (GetShowInformation) parameters
	 * (GetShowInformation) parameters
	 * @param mixed,... See function description for parameter options
	 * @return GetShowInformationResponse
	 * @throws Exception invalid function signature message
	 */
	public function GetShowInformation($mixed = null) {
		$validParameters = array(
			"(GetShowInformation)",
			"(GetShowInformation)",
		);
		$args = func_get_args();
		$this->_checkArguments($args, $validParameters);
		return $this->__soapCall("GetShowInformation", $args);
	}


	/**
	 * Service Call: GetSectorsForShow
	 * Parameter options:
	 * (GetSectorsForShow) parameters
	 * (GetSectorsForShow) parameters
	 * @param mixed,... See function description for parameter options
	 * @return GetSectorsForShowResponse
	 * @throws Exception invalid function signature message
	 */
	public function GetSectorsForShow($mixed = null) {
		$validParameters = array(
			"(GetSectorsForShow)",
			"(GetSectorsForShow)",
		);
		$args = func_get_args();
		$this->_checkArguments($args, $validParameters);
		return $this->__soapCall("GetSectorsForShow", $args);
	}


	/**
	 * Service Call: GetSeatsForSector
	 * Parameter options:
	 * (GetSeatsForSector) parameters
	 * (GetSeatsForSector) parameters
	 * @param mixed,... See function description for parameter options
	 * @return GetSeatsForSectorResponse
	 * @throws Exception invalid function signature message
	 */
	public function GetSeatsForSector($mixed = null) {
		$validParameters = array(
			"(GetSeatsForSector)",
			"(GetSeatsForSector)",
		);
		$args = func_get_args();
		$this->_checkArguments($args, $validParameters);
		return $this->__soapCall("GetSeatsForSector", $args);
	}


	/**
	 * Service Call: GetShowSeatStatus
	 * Parameter options:
	 * (GetShowSeatStatus) parameters
	 * (GetShowSeatStatus) parameters
	 * @param mixed,... See function description for parameter options
	 * @return GetShowSeatStatusResponse
	 * @throws Exception invalid function signature message
	 */
	public function GetShowSeatStatus($mixed = null) {
		$validParameters = array(
			"(GetShowSeatStatus)",
			"(GetShowSeatStatus)",
		);
		$args = func_get_args();
		$this->_checkArguments($args, $validParameters);
		return $this->__soapCall("GetShowSeatStatus", $args);
	}


	/**
	 * Service Call: GetShowPriceConfiguration
	 * Parameter options:
	 * (GetShowPriceConfiguration) parameters
	 * (GetShowPriceConfiguration) parameters
	 * @param mixed,... See function description for parameter options
	 * @return GetShowPriceConfigurationResponse
	 * @throws Exception invalid function signature message
	 */
	public function GetShowPriceConfiguration($mixed = null) {
		$validParameters = array(
			"(GetShowPriceConfiguration)",
			"(GetShowPriceConfiguration)",
		);
		$args = func_get_args();
		$this->_checkArguments($args, $validParameters);
		return $this->__soapCall("GetShowPriceConfiguration", $args);
	}




	/**
	 * Service Call: GetMovieInformation
	 * Parameter options:
	 * (GetMovieInformation) parameters
	 * (GetMovieInformation) parameters
	 * @param mixed,... See function description for parameter options
	 * @return GetMovieInformationResponse
	 * @throws Exception invalid function signature message
	 */
	public function GetMovieInformation($mixed = null) {
		$validParameters = array(
			"(GetMovieInformation)",
			"(GetMovieInformation)",
		);
		$args = func_get_args();
		$this->_checkArguments($args, $validParameters);
		return $this->__soapCall("GetMovieInformation", $args);
	}


}