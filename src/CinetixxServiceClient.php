<?php

namespace LeanStack\CinetixxClient;

use LeanStack\CinetixxClient\Model\Event;
use LeanStack\CinetixxClient\Model\Show;

class CinetixxServiceClient
{
    /** WSDL location for this service */
    const WSDL = "http://services.cinetixx.eu/Services/CinetixxService.asmx?WSDL";

    /** @var int */
    protected $mandatorId;

    /** @var \Zend\Soap\Client */
    protected $soapClient;

    /** @var \Sabre\Xml\Service */
    protected $mapper;

    /**
     * CinetixxServiceClient constructor.
     */
    public function __construct(int $mandatorId)
    {
        $options = [
        ];

        $this->mandatorId = $mandatorId;
        $this->soapClient = new \Zend\Soap\Client(self::WSDL, $options);

        $this->mapper = new \Sabre\Xml\Service();
        $this->mapper->elementMap = [
            'Show' => function(\Sabre\Xml\Reader $reader) {
                return \Sabre\Xml\Deserializer\keyValue($reader, '');
            },
            'ShowInfo' => function(\Sabre\Xml\Reader $reader) {
                return \Sabre\Xml\Deserializer\repeatingElements($reader, '{}Show');
            },
        ];

    }

    public function getEvents() {
        $showInfo = $this->soapClient->GetShowInfo(['mandatorId' => $this->mandatorId]);
        $shows = $this->mapper->parse($showInfo->GetShowInfoResult->any);

        return $this->mapShowsToEvents($shows);
    }

    /**
     * @param array $shows
     * @return Event[]
     */
    private function mapShowsToEvents(array $shows) {

        $events = array_reduce( $shows, function ($current, $show) {

            if (!array_key_exists($show['EVENT_ID'], $current)) {

                $event = new Event(
                    $show['EVENT_ID'],
                    $show['VERANSTALTUNGSTITEL']
                );
                $current[$show['EVENT_ID']] = $event;

            } else {

                $event = $current[$show['EVENT_ID']];

            }

            $event->addShow(new Show(
                new \DateTime($show['SHOW_BEGINNING'])
            ));

            return $current;
        },  []);

        return $events;
    }
}