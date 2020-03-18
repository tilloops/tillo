<?php

use RewardCloud\Api\BrandTemplate;

class BrandTemplateTest extends TilloTestCase
{

    /**
     * @var BrandTemplate
     */
    public $template;

    protected function setUp(): void
    {
        parent::setUp();

        $this->template = $this->client->template;
    }

    public function testRequest()
    {
        $params = [
            'brand' => 'tesco',
        ];

        $this->template->request($params);
        $response = $this->template->getResponse();
        $responseHeaders = $response->getHeaders();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('OK', $response->getReasonPhrase());

        $this->assertStringStartsWith('attachment;', $responseHeaders['Content-Disposition'][0]);
        $this->assertEquals('application/zip', $responseHeaders['Content-Type'][0]);
    }

    public function testList()
    {
        $params = [
            'brand' => 'tesco',
        ];

        $response = $this->template->list($params);

        $this->assertIsArray($response);
        $this->assertArrayNotHasKey('error', $response, $response['error']['message'] ?? '');

        $this->assertEquals('000', $response['code']);
        $this->assertEquals('success', $response['status']);
        $this->assertEquals('Template information for [tesco]', $response['message']);
    }
}
