<?php

namespace LeanStack\CinetixxAPI\Model;

use DateTime;
use Exception;

class Show
{
	/** @var int */
	private $id;

	/** @var DateTime */
	private $showStart;

	/** @var DateTime */
	private $sellingStart;

	/** @var DateTime */
	private $sellingEnd;

  /** @var string */
	private $cinetixxLink;

	/**
	 * @return int
	 */
	public function getId(): int
	{
		return $this->id;
	}

	/**
	 * @param int $id
	 * @return Show
	 */
	public function setId(int $id): Show
	{
		$this->id = $id;
		return $this;
	}

	/**
	 * @return DateTime
	 */
	public function getShowStart(): DateTime
	{
		return $this->showStart;
	}

	/**
	 * @param string $showStart
	 * @return Show
	 * @throws Exception
	 */
	public function setShowStart(string $showStart): Show
	{
		$this->showStart = new DateTime($showStart);
		return $this;
	}

	/**
	 * @return DateTime
	 */
	public function getSellingStart(): DateTime
	{
		return $this->sellingStart;
	}

	/**
	 * @param string $sellingStart
	 * @return Show
	 * @throws Exception
	 */
	public function setSellingStart(string $sellingStart): Show
	{
		$this->sellingStart = new DateTime($sellingStart);
		return $this;
	}

	/**
	 * @return DateTime
	 */
	public function getSellingEnd(): DateTime
	{
		return $this->sellingEnd;
	}

	/**
	 * @param string $sellingEnd
	 * @return Show
	 * @throws Exception
	 */
	public function setSellingEnd(string $sellingEnd): Show
	{
		$this->sellingEnd = new DateTime($sellingEnd);
		return $this;
	}

	/**
	 * @return string
	 */
	public function getCinetixxLink(): string
	{
		return $this->cinetixxLink;
	}

	/**
	 * @param string $cinetixxLink
	 * @return Show
	 */
	public function setCinetixxLink(string $cinetixxLink): Show
	{
		$this->cinetixxLink = $cinetixxLink;
		return $this;
	}
}
