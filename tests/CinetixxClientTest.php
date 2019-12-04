<?php

namespace LeanStack\CinetixxAPI\Tests;

use LeanStack\CinetixxAPI\CinetixxClient;
use PHPUnit\Framework\TestCase;

class CinetixxClientTest extends TestCase
{
	private $client;

	protected function setUp(): void
	{
		$this->client = new CinetixxClient(MANDATOR_ID);
	}

	public function testIsCreatable()
	{
		$this->assertInstanceOf(CinetixxClient::class, $this->client);
	}
}
