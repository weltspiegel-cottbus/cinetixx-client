<?php

namespace LeanStack\CinetixxAPI;

use Exception;
use LeanStack\CinetixxAPI\Model\Event;
use LeanStack\CinetixxAPI\Model\Show;
use Psr\Cache\InvalidArgumentException;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;

class CinetixxClient
{
	/**
	 * @var int
	 */
	private $mandatorId;

	/**
	 * @var CacheInterface
	 */
	private $cache;

	/**
	 * CinetixxClient constructor.
	 * @param int $mandatorId
	 */
	public function __construct(int $mandatorId)
	{
		$this->mandatorId = $mandatorId;
		$this->cache = new FilesystemAdapter('cinetixx', 3600, dirname(__DIR__).'/.cache');
	}

	/**
	 * @return Event[]
	 * @throws Exception
	 * @throws InvalidArgumentException
	 */
	public function getEvents(): array
	{
		try {
			$responseBody = $this->cache->get('response', function (ItemInterface $item) {

				$httpClient = HttpClient::create();
				$response = $httpClient->request('GET',
					'https://api.cinetixx.de/Services/CinetixxService.asmx/GetShowInfoV6',[ 'query' =>
						[
							'mandatorId' => $this->mandatorId
						]
					]);

				return $response->getContent();
			});

			$crawler = new Crawler($responseBody);

			$eventIds = []; // Collecting unique event ids
			$events = [];   // Mapped events

			$crawler->filterXPath('//Show')->each(function (Crawler $node) use (&$eventIds, &$events) {

				$eventId = $node->filterXPath('Show/EVENT_ID')->text();
				$event = null;

				// New unique event => push it on the events array
				if (array_search($eventId, $eventIds) === false) {
					$eventIds[] = $eventId;
					$event = new Event();
						$event
							->setId(intval($eventId))
							->setTitle($node->filterXPath('Show/VERANSTALTUNGSTITEL')->text())
							->setText($node->filterXPath('Show/TEXT')->text())
							->setTextShort($node->filterXPath('Show/TEXT_SHORT')->text())
							->setGenre($node->filterXPath('Show/GENRE')->text())
							->setFormat3D($node->filterXPath('Show/FLAG_3D')->text())
							->setDuration($node->filterXPath('Show/SPIELDAUER_EVENT')->text())
							->setLanguage($node->filterXPath('Show/LANGUAGE')->text())
							->setFsk($node->filterXPath('Show/ALTERSFREIGABE')->text())
							->setPoster($node->filterXPath('Show/ARTWORK')->text())
							->setPosterBig($node->filterXPath('Show/ARTWORK_BIG')->text())
							->setTrailerLink($node->filterXPath('Show/MOVIE_LINK')->text())
							->addImage($node->filterXPath('Show/IMAGE_1')->text())
							->addImage($node->filterXPath('Show/IMAGE_2')->text())
							->addImage($node->filterXPath('Show/IMAGE_3')->text())
						;
					$events[$eventId] = $event;
				} else {
					$event = $events[$eventId];
				}

				// Add show to event
				$show = new Show();
				$show
					->setId(intval($node->filterXPath('Show/SHOW_ID')->text()))
					->setShowStart($node->filterXPath('Show/SHOW_BEGINNING')->text())
					->setSellingStart($node->filterXPath('Show/VERKAUFSSTART')->text())
					->setSellingEnd($node->filterXPath('Show/VERKAUFSENDE')->text())
					->setCinetixxLink($node->filterXPath('Show/BOOKING_LINK')->text())
				;
				$event->addShow($show);

			});
			return $events;
		} catch (\Throwable $e) {
			throw new Exception($e->getMessage());
		}
	}

	/**
	 * @param int $eventId
	 * @return Event|mixed
	 * @throws Exception
	 * @throws InvalidArgumentException
	 */
	public function getEvent(int $eventId)
	{
		return $this->getEvents()[$eventId];
	}
}
