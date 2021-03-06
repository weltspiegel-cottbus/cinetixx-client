<?php

namespace LeanStack\CinetixxAPI\Tests;

use LeanStack\CinetixxAPI\CinetixxClient;
use LeanStack\CinetixxAPI\Model\Event;
use LeanStack\CinetixxAPI\Model\Show;
use PHPUnit\Framework\TestCase;
use Psr\Cache\InvalidArgumentException;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\HttpClient\HttpClient;

class CinetixxClientTest extends TestCase
{
	private $client;

	protected function setUp(): void
	{
		$client = HttpClient::create();
		$cache = new FilesystemAdapter('cinetixx', 3600, dirname(__DIR__).'/.cache');
		$cache->clear();
		$this->client = new CinetixxClient($_ENV['MANDATOR_ID'], $client, $cache);
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
	 */
	public function testReturnedEventsHaveTitles(Event $event)
	{
		if($event !== null) {
			$this->assertNotEmpty($event->getTitle());
		}
	}

	/**
	 * @depends testReturnedEventsHaveIds
	 * @param Event $event
	 */
	public function testReturnedEventsHaveTexts(Event $event)
	{
		if($event !== null) {
			$this->assertNotEmpty($event->getText());
		}
	}

	/**
	 * @depends testReturnedEventsHaveIds
	 * @param Event $event
	 */
	public function testReturnedEventsHaveShortTexts(Event $event)
	{
		if($event !== null) {
			$this->assertIsString($event->getTextShort());
		}
	}

	/**
	 * @depends testReturnedEventsHaveIds
	 * @param Event $event
	 */
	public function testReturnedEventsHaveLangzages(Event $event)
	{
		if($event !== null) {
			$this->assertNotEmpty($event->getLanguage());
		}
	}

	/**
	 * @depends testReturnedEventsHaveIds
	 * @param Event $event
	 */
	public function testReturnedEventsHaveGenres(Event $event)
	{
		if($event !== null) {
			$this->assertNotEmpty($event->getGenre());
		}
	}

	/**
	 * @depends testReturnedEventsHaveIds
	 * @param Event $event
	 */
	public function testReturnedEventsHaveDurations(Event $event)
	{
		if($event !== null) {
			$this->assertNotEmpty($event->getDuration());
		}
	}

	/**
	 * @depends testReturnedEventsHaveIds
	 * @param Event $event
	 */
	public function testReturnedEventsHaveRatings(Event $event)
	{
		if($event !== null) {
			$this->assertNotEmpty($event->getFsk());
		}
	}

	/**
	 * @depends testReturnedEventsHaveIds
	 * @param Event $event
	 */
	public function testReturnedEventsHaveFormatFlags(Event $event)
	{
		if($event !== null) {
			$this->assertIsBool($event->isFormat3D());
		}
	}

	/**
	 * @depends testReturnedEventsHaveIds
	 * @param Event $event
	 */
	public function testReturnedEventsHavePosters(Event $event)
	{
		if($event !== null) {
			$this->assertNotEmpty($event->getPoster());
		}
	}

	/**
	 * @depends testReturnedEventsHaveIds
	 * @param Event $event
	 */
	public function testReturnedEventsHaveBigPosters(Event $event)
	{
		if($event !== null) {
			$this->assertNotEmpty($event->getPosterBig());
		}
	}

	/**
	 * @depends testReturnedEventsHaveIds
	 * @param Event $event
	 */
	public function testReturnedEventsHaveTrailerLinks(Event $event)
	{
		if($event !== null) {
			$this->assertNotEmpty($event->getTrailerLink());
		}
	}

	/**
	 * @depends testReturnedEventsHaveIds
	 * @param Event $event
	 */
	public function testReturnedEventsHaveLocations(Event $event)
	{
		if($event !== null) {
			$this->assertNotEmpty($event->getLocation());
		}
	}

	/**
	 * @depends testReturnedEventsHaveIds
	 * @param Event $event
	 */
	public function testReturnedEventsHaveImages(Event $event)
	{
		if($event !== null) {
			$this->assertIsArray($event->getImages());
		}
	}

	/**
	 * @depends testReturnedEventsHaveIds
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
	 */
	public function testReturnedShowsHaveIds(Show $show)
	{
		if($show !== null) {
			$this->assertGreaterThan(0, $show->getId());
		}
	}

	/**
	 * @depends testReturnedEventsHaveShows
	 * @param Show $show
	 */
	public function testReturnedShowsHaveShowStarts(Show $show)
	{
		if($show !== null) {
			$this->assertInstanceOf(\DateTime::class, $show->getShowStart());
		}
	}

	/**
	 * @depends testReturnedEventsHaveShows
	 * @param Show $show
	 */
	public function testReturnedShowsHaveSellingStarts(Show $show)
	{
		if($show !== null) {
			$this->assertInstanceOf(\DateTime::class, $show->getSellingStart());
		}
	}

	/**
	 * @depends testReturnedEventsHaveShows
	 * @param Show $show
	 */
	public function testReturnedShowsHaveSellingEnds(Show $show)
	{
		if($show !== null) {
			$this->assertInstanceOf(\DateTime::class, $show->getSellingEnd());
		}
	}

	/**
	 * @depends testReturnedEventsHaveShows
	 * @param Show $show
	 */
	public function testReturnedShowsHaveCinetixxLinks(Show $show)
	{
		if($show !== null) {
			$this->assertIsString($show->getCinetixxLink());
		}
	}

	/**
	 * @depends testReturnedEventsHaveShows
	 * @param Show $show
	 */
	public function testReturnedShowsHaveKinoheldLinks(Show $show)
	{
		if($show !== null) {
			$this->assertIsString($show->getKinoheldLink());
		}
	}
}
