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
use Symfony\Contracts\HttpClient\HttpClientInterface;

class CinetixxClient
{
	/**
	 * @var int
	 */
	private $mandatorId;

	/**
	 * @var HttpClientInterface
	 */
	private $httpClient;

	/**
	 * @var CacheInterface
	 */
	private $cache;

	/**
	 * CinetixxClient constructor.
	 * @param int $mandatorId
	 * @param HttpClientInterface $httpClient
	 * @param CacheInterface $cache
	 */
	public function __construct(int $mandatorId, HttpClientInterface $httpClient, CacheInterface $cache)
	{
		$this->mandatorId = $mandatorId;
		$this->httpClient = $httpClient;
		$this->cache = $cache;
	}

	/**
	 * @return Event[]
	 * @throws Exception
	 * @throws InvalidArgumentException
	 */
	public function getEvents(): array
	{
		$responseBody = $this->cache->get('response', function (ItemInterface $item) {

			$response = $this->httpClient->request('GET',
				'https://api.cinetixx.de/Services/CinetixxService.asmx/GetShowInfoV6', ['query' =>
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
					->addImage($node->filterXPath('Show/IMAGE_3')->text());

				// Saal auswerten, um Location (Weltspiegel oder Autokino) zu bestimmen
				$saal = $node->filterXPath('Show/SAAL')->text();
				$event->setLocation(strcasecmp('Lausitzer AutokinoFestival', $saal) === 0 ?
					'Autokino' : 'Weltspiegel');

				$events[$eventId] = $event;
			} else {
				$event = $events[$eventId];
			}

			// Kinoheld Link zusammensetzen
			$locationPath = $event->getLocation() == 'Autokino' ? 'lausitzer-autokinofestival-cottbus' : 'filmtheater-weltspiegel';
			$baseUrl = 'https://www.kinoheld.de/kino-cottbus/' . $locationPath . '/vorstellung/';

			// Add show to event
			$show = new Show();
			$show
				->setId(intval($node->filterXPath('Show/SHOW_ID')->text()))
				->setShowStart($node->filterXPath('Show/SHOW_BEGINNING')->text())
				->setSellingStart($node->filterXPath('Show/VERKAUFSSTART')->text())
				->setSellingEnd($node->filterXPath('Show/VERKAUFSENDE')->text())
				->setCinetixxLink($node->filterXPath('Show/BOOKING_LINK')->text())
				->setKinoheldLink($baseUrl . $show->getId() . '?mode=widget#panel-seats')
			;

			$event->addShow($show);

		});
		return $events;
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
