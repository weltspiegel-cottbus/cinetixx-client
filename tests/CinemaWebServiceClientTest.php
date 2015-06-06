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
        $eventIds = [];

        $now = new DateTime();
        $from = $now->modify('today noon');
        $now = new DateTime();
        $to = $now->modify('next friday');

        $events = $this->client->GetEventsForCinema(self::CINEMA_ID,$from,$to);
        $this->assertInternalType('array',$events);

        foreach($events as $ev) {
            $eventIds[] = $ev->EventId;
        }

        return $eventIds;
    }

    /**
     * @depends testGetEvents
     * @param integer[] $eventIds
     */
    public function testGetShowsForEvents(array $eventIds)
    {

        $now = new DateTime();
        $from = $now->modify('today');
        $now = new DateTime();
        $to = $now->modify('tomorrow');

        array_walk($eventIds, function ($id) use ($from,$to) {
            $shows = $this->client->GetShowsForEvent($id,$from,$to);
            $this->assertInternalType('array',$shows);
        });
    }

    /**
     * @depends testGetEvents
     * @param integer[] $eventIds
     */
    public function testGetEventInformation(array $eventIds)
    {
        array_walk($eventIds, function ($id) {
            $infos = $this->client->GetEventInformation($id);
            $this->assertNotNull($infos);
        });
    }
}
