<?php

namespace LeanStack\CinetixxAPI\Tests;

use LeanStack\CinetixxAPI\CinetixxClient;
use LeanStack\CinetixxAPI\Model\Event;
use LeanStack\CinetixxAPI\Model\Show;
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

	/**
	 * @depends testReturnedEventsHaveTitles
	 * @param Event $event
	 * @return Show
	 */
	public function testReturnedEventsHaveShows(Event $event)
	{
		$show = null;

		if($event !== null) {
			$shows = $event->getShows();
			$this->assertIsArray($shows);
			if (count($shows) > 0) {
				$show = $shows[0];
				$this->assertInstanceOf(Show::class, $show);
			}
		}

		return $show;
	}

	/**
	 * @depends testReturnedEventsHaveShows
	 * @param Show $show
	 * @return Show
	 */
	public function testReturnedShowsHaveIds(Show $show)
	{
		if($show !== null) {
			$this->assertGreaterThan(0, $show->getId());
		}
		return $show;
	}

	/**
	 * @depends testReturnedEventsHaveShows
	 * @param Show $show
	 * @return Show
	 */
	public function testReturnedShowsHaveShowStarts(Show $show)
	{
		if($show !== null) {
			$this->assertInstanceOf(\DateTime::class, $show->getShowStart());
		}
		return $show;
	}

	/**
	 * @depends testReturnedEventsHaveShows
	 * @param Show $show
	 * @return Show
	 */
	public function testReturnedShowsHaveSellingStarts(Show $show)
	{
		if($show !== null) {
			$this->assertInstanceOf(\DateTime::class, $show->getSellingStart());
		}
		return $show;
	}

	/**
	 * @depends testReturnedEventsHaveShows
	 * @param Show $show
	 * @return Show
	 */
	public function testReturnedShowsHaveSellingEnds(Show $show)
	{
		if($show !== null) {
			$this->assertInstanceOf(\DateTime::class, $show->getSellingEnd());
		}
		return $show;
	}

	/**
	 * @depends testReturnedEventsHaveShows
	 * @param Show $show
	 * @return Show
	 */
	public function testReturnedShowsHaveCinetixxLinks(Show $show)
	{
		if($show !== null) {
			$this->assertIsString($show->getCinetixxLink());
		}
		return $show;
	}
}
