<?php


use RewardCloud\RewardCloud;

class TilloTestCase extends PHPUnit\Framework\TestCase
{
    /**
     * @var RewardCloud
     */
    public $client;

    protected function setUp(): void
    {
        $apiKey    = 'API_KEY';
        $apiSecret = 'API_SECRET';
        $apiBase   = 'API_BASE';

        $this->client = new RewardCloud($apiKey, $apiSecret, $apiBase);
    }

}
