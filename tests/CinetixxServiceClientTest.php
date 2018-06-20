<?php

use PHPUnit\Framework\TestCase;

use LeanStack\CinetixxClient\CinetixxServiceClient;
use LeanStack\CinetixxClient\Model\Event;

class CinetixxServiceClientTest extends TestCase
{
    /** @var LeanStack\CinetixxClient\CinetixxServiceClient */
    protected $client;

    public function testIsInstantiatable()
    {
        $this->assertNotNull($this->client);
    }

    public function testGetEventsReturnsAnArray()
    {
        $events = $this->client->getEvents();
        $this->assertNotNull($events);
        $this->assertInternalType('array', $events);
    }

    public function testGetEventsReturnsAnArrayOfEvents()
    {
        $events = $this->client->getEvents();
var_dump(current($events));
        if (count($events) > 0) {
            $this->assertInstanceOf(Event::class, current($events));
        }
    }
    /**
     * This method is called before each test.
     */
    protected function setUp()
    {
        $this->client = new CinetixxServiceClient(MANDATOR_ID);
    }


}
