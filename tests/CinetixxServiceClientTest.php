<?php

use LeanStack\CinetixxClient\CinetixxServiceClient;
use PHPUnit\Framework\TestCase;

class CinetixxServiceClientTest extends TestCase
{
    /** @var LeanStack\CinetixxClient\CinetixxServiceClient */
    protected $client;

    public function testIsInstantiatable()
    {
        $this->assertNotNull($this->client);
    }

    /**
     * This method is called before each test.
     */
    protected function setUp()
    {
        $this->client = new LeanStack\CinetixxClient\CinetixxServiceClient();
    }


}
