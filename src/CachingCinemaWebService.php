<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace LeanStack\CinetixxClient;

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
}
