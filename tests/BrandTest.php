<?php

use RewardCloud\Api\Brand;

class BrandTest extends TilloTestCase
{

    /**
     * @var Brand
     */
    public $brand;

    protected function setUp(): void
    {
        parent::setUp();

        $this->brand = $this->client->brand;
    }

    public function testList()
    {
        $params = [
            'brand' => 'amazon',
            'detail' => 'true',
        ];

        $response = $this->brand->list($params);

        $this->assertIsArray($response);
        $this->assertArrayNotHasKey('error', $response, $response['error']['message'] ?? '');

        $this->assertEquals('000', $response['code']);
        $this->assertEquals('success', $response['status']);
        $this->assertEquals('Brand information for [amazon] with details', $response['message']);

    }

    public function testCheckFloat()
    {
        $params = [
            'currency' => 'GBP',
        ];

        $response = $this->brand->checkFloat($params);

        $this->assertIsArray($response);
        $this->assertArrayNotHasKey('error', $response, $response['error']['message'] ?? '');

        $this->assertEquals('000', $response['code']);
        $this->assertEquals('success', $response['status']);

        $this->assertArrayHasKey('GBP', $response['data']['floats']);
    }
}
