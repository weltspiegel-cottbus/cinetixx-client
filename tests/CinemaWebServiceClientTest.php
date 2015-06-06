<?php

class CinemaWebServiceClientTest extends PHPUnit_Framework_TestCase
{
    // Constant CinemaId
    const CINEMA_ID = 808957959;

    /** @var  \LeanStack\CinetixxClient\CinemaWebService */
    protected $client;

    protected function setUp()
    {
        $authToken = new \LeanStack\CinetixxClient\Auth\Token("ZACO_WEBSERVICE","c46f44194070");
        $this->client = new \LeanStack\CinetixxClient\CinemaWebService($authToken, true);
    }

    public function testGetEvents()
    {
        $now = new DateTime();
        $from = $now->modify('today noon');
        $now = new DateTime();
        $to = $now->modify('next friday');

        $events = $this->client->GetEventsForCinema(self::CINEMA_ID,$from,$to);
        $this->assertInternalType('array',$events);
    }
}
