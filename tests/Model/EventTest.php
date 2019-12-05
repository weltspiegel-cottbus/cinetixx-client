<?php

namespace LeanStack\CinetixxAPI\Tests\Model;

use LeanStack\CinetixxAPI\Model\Event;
use PHPUnit\Framework\TestCase;

class EventTest extends TestCase
{
	private $event;

	protected function setUp(): void
	{
		$this->event = new Event();
	}

	public function testHasId()
	{
		$this->event->setId(17);
		$this->assertEquals(17, $this->event->getId());
	}

	public function testHasTitle()
	{
		$this->event->setTitle('Frozem');
		$this->assertEquals('Frozem', $this->event->getTitle());
	}
}
