<?php

namespace LeanStack\CinetixxAPI\Tests\Model;

use LeanStack\CinetixxAPI\Model\Event;
use LeanStack\CinetixxAPI\Model\Show;
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

	public function testHasText()
	{
		$this->event->setText('Elsa and Anna');
		$this->assertEquals('Elsa and Anna', $this->event->getText());
	}

	public function testHasTextShort()
	{
		$this->event->setTextShort('Elsa & Anna');
		$this->assertEquals('Elsa & Anna', $this->event->getTextShort());
	}

	public function testHasLanguage()
	{
		$this->event->setLanguage('Deutsch');
		$this->assertEquals('Deutsch', $this->event->getLanguage());
	}

	public function testHasGenre()
	{
		$this->event->setGenre('Animation');
		$this->assertEquals('Animation', $this->event->getGenre());
	}

	public function testHasFsk()
	{
		$this->event->setFsk('ab 0');
		$this->assertEquals('ab 0', $this->event->getFsk());
	}

	public function testHasDuration()
	{
		$this->event->setDuration('105');
		$this->assertEquals('105', $this->event->getDuration());
	}

	public function testHasFormat3D()
	{
		$this->event->setFormat3D(true);
		$this->assertTrue($this->event->isFormat3D());
	}

	public function testHasPoster()
	{
		$this->event->setPoster('poster.png');
		$this->assertEquals('poster.png', $this->event->getPoster());
	}

	public function testHasPosterBig()
	{
		$this->event->setPosterBig('poster-big.png');
		$this->assertEquals('poster-big.png', $this->event->getPosterBig());
	}

	public function testHasTrailerLink()
	{
		$this->event->setTrailerLink('https://youtu.be/dZ7UU2JeAvo');
		$this->assertEquals('https://youtu.be/dZ7UU2JeAvo', $this->event->getTrailerLink());
	}

	public function testHasYoutubeId()
	{
		$this->event->setYoutubeId('abcdefghijk');
		$this->assertEquals('abcdefghijk', $this->event->getYoutubeId());
	}

	public function testHasImages()
	{
		$this->event->addImage('img1.png');
		$this->event->addImage('img2.png');
		$this->assertEquals(2, count($this->event->getImages()));
	}

	public function testHasShows()
	{
		$this->event->addShow(new Show());
		$this->event->addShow(new Show());
		$this->event->addShow(new Show());
		$this->assertEquals(3, count($this->event->getShows()));
	}
}
