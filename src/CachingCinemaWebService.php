<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace LeanStack\CinetixxClient;

use Lean\Cache\CacheItemPool;

use LeanStack\CinetixxClient\Auth\Token;

use LeanStack\CinetixxClient\DTO\Event;
use LeanStack\CinetixxClient\DTO\EventInformation;
use LeanStack\CinetixxClient\DTO\Image;
use LeanStack\CinetixxClient\DTO\ShowDetail;
use LeanStack\CinetixxClient\DTO\TypedText;

use LeanStack\CinetixxClient\Message\GetEventImagesRequest;
use LeanStack\CinetixxClient\Message\GetEventInformationRequest;
use LeanStack\CinetixxClient\Message\GetEventInformationResponse;
use LeanStack\CinetixxClient\Message\GetEventsForCinemaRequest;
use LeanStack\CinetixxClient\Message\GetMovieInformationRequest;
use LeanStack\CinetixxClient\Message\GetShowsForEventRequest;

/**
 * Description of CachingCinemaWebService
 *
 * @author Micha
 */
class CachingCinemaWebService extends CinemaWebService {
    
    /** @var \Lean\Cache\CacheItemPool */
    protected $cache;
    
    public function __construct(Token $authToken, $debug = false) {

        parent::__construct($authToken, $debug);

        $options = \phpFastCache::$config;
        $options['path'] = '/www/htdocs/w005eb31/tmp';
        $options['securityKey'] = 'ctx';

        $this->cache = new CacheItemPool('sqlite', $options);
    }
    
    public function GetEventsForCinema($cinemaId, \DateTime $dateFrom, \DateTime $dateUntil) {
        
        $key = 'events';
        $data = null;
        
        $item = $this->cache->getItem($key);
        if( $item->isHit() ) {
            $data = $item->get();
        } else {
            $data = parent::GetEventsForCinema($cinemaId, $dateFrom, $dateUntil);
            $item->set($data);
            $item->expiresAfter(30);
            $this->cache->save($item);
        }
        
        return $data;
    }
    
    public function GetEventImages($eventId) {
        
        $key = 'event_images_' . $eventId;
        $data = null;
        
        $item = $this->cache->getItem($key);
        if( $item->isHit() ) {
            $data = $item->get();
        } else {
            $data = parent::GetEventImages($eventId);
            $item->set($data);
            $item->expiresAfter(30);
            $this->cache->save($item);
        }
        
        return $data;
    }

    public function GetEventInformation($eventId) {
        
        $key = 'event_info_' . $eventId;
        $data = null;
        
        $item = $this->cache->getItem($key);
        if( $item->isHit() ) {
            $data = $item->get();
        } else {
            $data = parent::GetEventInformation($eventId);
            $item->set($data);
            $item->expiresAfter(30);
            $this->cache->save($item);
        }
        
        return $data;
    }

    public function GetMovieInformation($movieId) {
        
        $key = 'movie_info_' . $movieId;
        $data = null;
        
        $item = $this->cache->getItem($key);
        if( $item->isHit() ) {
            $data = $item->get();
        } else {
            $data = parent::GetMovieInformation($movieId);
            $item->set($data);
            $item->expiresAfter(30);
            $this->cache->save($item);
        }
        
        return $data;
      
    }

    public function GetShowsForEvent($eventId, \DateTime $dateFrom, \DateTime $dateUntil) {
        
        $key = 'event_shows_' . $eventId;
        $data = null;
        
        $item = $this->cache->getItem($key);
        if( $item->isHit() ) {
            $data = $item->get();
        } else {
            $data = parent::GetShowsForEvent($eventId, $dateFrom, $dateUntil);
            $item->set($data);
            $item->expiresAfter(30);
            $this->cache->save($item);
        }
        
        return $data;
    }

}
