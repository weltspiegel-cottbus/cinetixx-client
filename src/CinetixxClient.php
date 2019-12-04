<?php

namespace LeanStack\CinetixxAPI;

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
}
