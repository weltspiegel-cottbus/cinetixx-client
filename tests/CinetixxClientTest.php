<?php

namespace LeanStack\CinetixxAPI\Tests;

use LeanStack\CinetixxAPI\CinetixxClient;
use LeanStack\CinetixxAPI\Model\Event;
use PHPUnit\Framework\TestCase;
use Psr\Cache\InvalidArgumentException;

class CinetixxClientTest extends TestCase
{
	private $client;

	protected function setUp(): void
	{
		$this->client = new CinetixxClient(MANDATOR_ID);
	}

	public function testIsCreatable()
	{
		$this->assertInstanceOf(CinetixxClient::class, $this->client);
	}

	public function testHasGetEventsMethod()
	{
		$this->assertIsCallable([$this->client, 'getEvents']);
	}

	public function testGetEventsReturnsAnArrayOfEvents()
	{
		$events = $this->client->getEvents();
		$this->assertIsArray($events);

		$firstEvent = null;
		if(count($events) > 0) {
			$firstEvent = $events[array_keys($events)[0]];
			$this->assertInstanceOf(Event::class, $firstEvent);
		}
		return $firstEvent;
	}

	/**
	 * @depends testGetEventsReturnsAnArrayOfEvents
	 * @param Event $expected
	 * @throws InvalidArgumentException
	 */
	public function testGetEventReturnsSingleEventById(Event $expected)
	{
		$event = $this->client->getEvent($expected->getId());
		$this->assertEquals($expected->getTitle(), $event->getTitle());
	}

	/**
	 * @depends testGetEventsReturnsAnArrayOfEvents
	 * @param Event $event
	 * @return Event
	 */
	public function testReturnedEventsHaveIds(Event $event)
	{
		if($event !== null) {
			$this->assertGreaterThan(0, $event->getId());
		}
		return $event;
	}

	/**
	 * @depends testReturnedEventsHaveIds
	 * @param Event $event
	 * @return Event
	 */
	public function testReturnedEventsHaveTitles(Event $event)
	{
		if($event !== null) {
			$this->assertNotEmpty($event->getTitle());
		}
		return $event;
	}
}
