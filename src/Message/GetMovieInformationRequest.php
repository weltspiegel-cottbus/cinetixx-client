<?php

namespace LeanStack\CinetixxClient\Message;

/**
 * Class GetMovieInformation
 * @package LeanStack\CinetixxClient\Message
 */
class GetMovieInformationRequest {

	/**
	 * @var integer
	 */
	public $movieId;

    /**
     * GetMovieInformation constructor.
     * @param int $movieId
     */
    public function __construct($movieId)
    {
        $this->movieId = $movieId;
    }

}