<?php

namespace LeanStack\CinetixxAPI\Tests\Model;

use LeanStack\CinetixxAPI\Model\Show;
use PHPUnit\Framework\TestCase;

class ShowTest extends TestCase
{
	/** @var Show */
	private $show;

	protected function setUp(): void
	{
		$this->show = new Show();
	}

	public function testHasId()
	{
		$this->show->setId(17);
		$this->assertEquals(17, $this->show->getId());
	}

	public function testHasShowStart()
	{
		$showStart = new \DateTime('2019-12-04T16:45:00+01:00');
		try {
			$this->show->setShowStart($showStart->format(\DateTime::W3C));
		} catch (\Exception $e) {
		}
		$this->assertEquals($showStart, $this->show->getShowStart());
	}

	public function testHasSellingStart()
	{
		$sellingStart = new \DateTime('2019-12-04T16:45:00+01:00');
		try {
			$this->show->setSellingStart($sellingStart->format(\DateTime::W3C));
		} catch (\Exception $e) {
		}
		$this->assertEquals($sellingStart, $this->show->getSellingStart());
	}

	public function testHasSellingEnd()
	{
		$sellingEnd = new \DateTime('2019-12-04T16:45:00+01:00');
		try {
			$this->show->setSellingEnd($sellingEnd->format(\DateTime::W3C));
		} catch (\Exception $e) {
		}
		$this->assertEquals($sellingEnd, $this->show->getSellingEnd());
	}

	public function testHasCinetixxLink()
	{
		$cinetixxLink = 'https://booking.cinetixx.de/';
		try {
			$this->show->setCinetixxLink($cinetixxLink);
		} catch (\Exception $e) {
		}
		$this->assertEquals($cinetixxLink, $this->show->getCinetixxLink());
	}
}
