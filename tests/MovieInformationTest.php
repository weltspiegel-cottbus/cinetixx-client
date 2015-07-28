<?php

class MovieInformationTest extends PHPUnit_Framework_TestCase
{
    /** @var  \LeanStack\CinetixxClient\CinemaWebService */
    protected $client;

    protected function setUp()
    {
        $authToken = new \LeanStack\CinetixxClient\Auth\Token(CINETIXX_LOGIN,CINETIXX_PASSWD);
        $this->client = new \LeanStack\CinetixxClient\CinemaWebService($authToken, true);
    }

    public function testGetMovieInformation()
    {
        $movieId = 1377236969;
        $movie = $this->client->GetMovieInformation($movieId);
        $this->assertNotNull($movie);
        var_dump($movie);
    }
}