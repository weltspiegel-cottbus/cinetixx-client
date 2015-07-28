<?php

namespace LeanStack\CinetixxClient;

use LeanStack\CinetixxClient\Auth\Token;

use LeanStack\CinetixxClient\DTO\Event;
use LeanStack\CinetixxClient\DTO\EventInformation;
use LeanStack\CinetixxClient\DTO\Image;
use LeanStack\CinetixxClient\DTO\ShowDetail;
use LeanStack\CinetixxClient\DTO\TypedText;

use LeanStack\CinetixxClient\Message\GetEventImagesRequest;
use LeanStack\CinetixxClient\Message\GetEventInformationRequest;
use LeanStack\CinetixxClient\Message\GetEventInformationResponse;
use LeanStack\CinetixxClient\Message\GetEventsForCinemaRequest;
use LeanStack\CinetixxClient\Message\GetMovieInformationRequest;
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
        "GetEventInformationResponse" => GetEventInformationResponse::class,

        "DTOEventShort" => Event::class,
        "DTOShowDetail" => ShowDetail::class,
        "DTOEventInformation" => EventInformation::class,
        "DTOTypedText" => TypedText::class,
        "DTOImage" => Image::class,
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
                $screenedShows[] = $show;
        }
        return $screenedShows;
    }

    /**
     * Returns detail information for given event
     *
     * @param integer $eventId
     * @return EventInformation
     */
    public function GetEventInformation($eventId) {

        $args = new GetEventInformationRequest($eventId);

        /** @var GetEventInformationResponse $response */
        $response = $this->__soapCall("GetEventInformation", [$args]);

        return $response->GetEventInformationResult;
    }

    /**
     * Get images for given event id
     *
     * @param int $eventId
     * @return Image[]
     */
    public function GetEventImages($eventId) {

        $args = new GetEventImagesRequest($eventId);

        $response = $this->__soapCall("GetEventImages", [$args]);

        return $response->GetEventImagesResult->ImageList->DTOImage;
    }

    /**
     * Get detailed movie information
     * 
     * @param $movieId
     * @return \stdClass
     */
    public function GetMovieInformation($movieId) {

        $args = new GetMovieInformationRequest($movieId);

        $response = $this->__soapCall("GetMovieInformation", [$args]);

        return $response->GetMovieInformationResult;
    }
}