<?php

use LeanStack\CinetixxClient\Model\Event;
use PHPUnit\Framework\TestCase;

class EventTest extends TestCase
{
    /** @var Event */
    protected $event;

    protected function setUp()
    {
        $this->event = new Event(
            12345678,
            '12 MONKEYS'
        );
    }

    public function testHasEventId() {
        $this->assertNotNull($this->event->getEventId());
    }

    public function testHasTitle() {
        $this->assertNotNull($this->event->getTitle());
    }

    public function testHasShows() {
        $this->assertNotNull($this->event->getShows());
    }
}
