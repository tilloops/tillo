<?php

use RewardCloud\Api\DigitalCode;

class DigitalCodeTest extends TestCase
{
    /**
     * @var DigitalCode
     */
    public $digitalCode;

    protected function setUp(): void
    {
        parent::setUp();
        $this->digitalCode = $this->client->digitalCode;
    }

    /**
     * @param $requestId
     * @param $params
     *
     * @return array
     */
    protected function issueCode($requestId, $params = [])
    {
        $params = array_merge([
            'brand'                 => 'amazon',
            'client_request_id'     => $requestId,
            'delivery_method'       => 'code',
            'face_value'            => [
                'amount'   => 50.00,
                'currency' => 'GBP',
            ],
            'fulfilment_by'         => 'rewardcloud',
            'fulfilment_parameters' => [
                'from_email' => 'email@reward.cloud',
                'from_name'  => 'RewardCloud',
                'subject'    => 'Your Gift Card',
                'to_email'   => 'gift@reward.cloud',
                'to_name'    => 'Reward Cloud',
            ],
            'personalisation'       => [
                'from_name' => 'RewardCloud',
                'message'   => 'Here is your gift card',
                'template'  => 'standard',
                'to_name'   => 'Reward Cloud',
            ],
            'sector'                => 'voluntary-benefits',
        ], $params);

        return $this->digitalCode->issue($params);
    }

    public function testIssue()
    {
        $requestId = time();

        $response = $this->issueCode($requestId);

        $this->assertIsArray($response);
        $this->assertArrayNotHasKey('error', $response, $response['error']['message'] ?? '');

        $this->assertEquals('000', $response['code']);
        $this->assertEquals('success', $response['status']);
        $this->assertEquals('Card created successfully', $response['message']);

        $code = $response['data'];
        $this->assertEquals('amazon', $code['brand']);
        $this->assertEquals(50, $code['face_value']['amount']);
        $this->assertArrayHasKey('code', $code);
    }

    public function testReverse()
    {
        $issueRequestId = time();
        $codeResponse   = $this->issueCode($issueRequestId, [
            'brand'      => 'tesco',
            'face_value' => [
                'amount'   => 40.00,
                'currency' => 'GBP',
            ],
        ]);

        $this->assertArrayNotHasKey('error', $codeResponse, $codeResponse['error']['message'] ?? '');

        $params = [
            'client_request_id'          => time(),
            'original_client_request_id' => $issueRequestId,
            'brand'                      => 'tesco',
            'face_value'                 => [
                'amount'   => '40',
                'currency' => 'GBP',
            ],
            'sector'                     => 'voluntary-benefits',
        ];


        $response = $this->digitalCode->reverse($params);

        $this->assertIsArray($response);
        $this->assertArrayNotHasKey('error', $response, $response['error']['message'] ?? '');

        $this->assertEquals('000', $response['code']);
        $this->assertEquals('success', $response['status']);
        $this->assertEquals('Card cancelled successfully', $response['message']);
    }

    public function testCancel()
    {
        $codeRequestId = time();
        $codeResponse  = $this->issueCode($codeRequestId, [
            'brand'      => 'amazon',
            'face_value' => [
                'amount'   => 35.00,
                'currency' => 'GBP',
            ],
        ]);

        $this->assertArrayNotHasKey('error', $codeResponse, $codeResponse['error']['message'] ?? '');

        $this->assertEquals('000', $codeResponse['code']);
        $this->assertEquals('success', $codeResponse['status']);

        $issueCode = $codeResponse['data']['code'];

        $params = [
            'client_request_id'          => time(),
            'original_client_request_id' => $codeRequestId,
            'brand'                      => 'amazon',
            'face_value'                 => [
                'amount'   => 35,
                'currency' => 'GBP',
            ],
            'code'                       => $issueCode,
            'sector'                     => 'voluntary-benefits',
//            'tags'                       => ['premium', 'lifetime'],
        ];

        $response = $this->digitalCode->cancel($params);

        $this->assertIsArray($response);
        $this->assertArrayNotHasKey('error', $response, $response['error']['message'] ?? '');

        $this->assertEquals('000', $response['code']);
        $this->assertEquals('success', $response['status']);
        $this->assertEquals('Card cancelled successfully', $response['message']);
    }

    public function testCashOut()
    {

        $codeRequestId = time();
        $codeResponse  = $this->issueCode($codeRequestId, [
            'brand'      => 'tesco',
            'face_value' => [
                'amount'   => 35.00,
                'currency' => 'GBP',
            ],
        ]);

        $this->assertArrayNotHasKey('error', $codeResponse, $codeResponse['error']['message'] ?? '');
        $this->assertEquals('000', $codeResponse['code']);
        $this->assertEquals('success', $codeResponse['status']);

        $params = [
            'client_request_id'          => time(),
            'original_client_request_id' => $codeRequestId,
            'brand'                      => 'tesco',
            'sector'                     => 'voluntary-benefits',
//            'tags'                       => ['premium', 'lifetime'],
        ];

        $response = $this->digitalCode->cashOut($params);

        $this->assertIsArray($response);
        $this->assertArrayNotHasKey('error', $response, $response['error']['message'] ?? '');

        $this->assertEquals('000', $response['code']);
        $this->assertEquals('success', $response['status']);
        $this->assertEquals('Card cashed out successfully', $response['message']);
    }

    public function testCheckBalance()
    {
        $codeRequestId = time();
        $codeResponse  = $this->issueCode($codeRequestId, [
            'brand'      => 'tesco',
            'face_value' => [
                'amount'   => 35.00,
                'currency' => 'GBP',
            ],
        ]);

        $this->assertArrayNotHasKey('error', $codeResponse, $codeResponse['error']['message'] ?? '');

        $this->assertEquals('000', $codeResponse['code']);
        $this->assertEquals('success', $codeResponse['status']);

        $codeData = $codeResponse['data'];

        $params = [
            'client_request_id' => time(),
            'brand'             => 'tesco',
            'face_value'        => [
                'currency' => 'GBP',
            ],
            'code'              => $codeData['code'],
            'pin'               => $codeData['pin'],
            'sector'            => 'voluntary-benefits',
        ];

        $response = $this->digitalCode->checkBalance($params);

        $this->assertIsArray($response);
        $this->assertArrayNotHasKey('error', $response, $response['error']['message'] ?? '');

        $this->assertEquals('000', $response['code']);
        $this->assertEquals('success', $response['status']);
        $this->assertEquals('Card balance retrieved successfully', $response['message']);

        $this->assertEquals(35, $response['data']['face_value']['amount']);
        $this->assertEquals('GBP', $response['data']['face_value']['currency']);
    }

    public function testCheckStock()
    {
        $params = [
            'brand' => 'm-and-s',
        ];

        $response = $this->digitalCode->checkStock($params);

        $this->assertIsArray($response);
        $this->assertArrayNotHasKey('error', $response, $response['error']['message'] ?? '');

        $this->assertEquals('000', $response['code']);
        $this->assertEquals('success', $response['status']);
        $this->assertEquals('Stock levels for [m-and-s]', $response['message']);
    }


}
