<?php

namespace LeanStack\CinetixxAPI;

use Exception;
use LeanStack\CinetixxAPI\Model\Event;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpClient\HttpClient;

class CinetixxClient
{
	/**
	 * @var int
	 */
	private $mandatorId;

	/**
	 * CinetixxClient constructor.
	 * @param int $mandatorId
	 */
	public function __construct(int $mandatorId)
	{
		$this->mandatorId = $mandatorId;
	}

	/**
	 * @return Event[]
	 * @throws Exception
	 */
	public function getEvents(): array
	{
		try {
			$httpClient = HttpClient::create();
			$response = $httpClient->request('GET', 'https://api.cinetixx.de/Services/CinetixxService.asmx/GetShowInfoV6?mandatorId=' . $this->mandatorId);

			$crawler = new Crawler($response->getContent());

			$eventIds = []; // Collecting unique event ids
			$events = [];   // Mapped events

			$crawler->filterXPath('//Show')->each(function (Crawler $node) use (&$eventIds, &$events) {

				$eventId = $node->filterXPath('Show/EVENT_ID')->text();
				$event = null;

				// New unique event => push it on the events array
				if (array_search($eventId, $eventIds) === false) {
					$eventIds[] = $eventId;
					$event = new Event();
					$event->setId(intval($eventId));
					$event->setTitle($node->filterXPath('Show/VERANSTALTUNGSTITEL')->text());
					$events[$eventId] = $event;
				} else {
					$event = $events[$eventId];
				}

			});
			return $events;
		} catch (\Throwable $e) {
			throw new Exception($e->getMessage());
		}
	}
}
