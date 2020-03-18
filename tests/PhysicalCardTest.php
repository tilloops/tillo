<?php


use RewardCloud\Api\PhysicalCard;

class PhysicalCardTest extends TestCase
{

    /**
     * @var PhysicalCard
     */
    public $physicalCard;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->physicalCard = $this->client->physicalCard;
    }

    /**
     * @doesNotPerformAssertions
     */
    public function testActivate()
    {
        $params = [
            'client_request_id' => '[[CLIENT_REQUEST_ID]]',
            'brand'             => 'halfords',
            'face_value'        => [
                'amount'   => 10,
                'currency' => 'GBP',
            ],
            'code'              => '5045075881749921774',
            'pin'               => '5947',
            'tags'              => ['Lloyds', 'CustomerType', 'Premium'],
            'sector'            => 'voluntary-benefits',
        ];

//        $response = $this->physicalCard->activate($params);


    }

    /**
     * @doesNotPerformAssertions
     */
    public function testCancel()
    {
        $params = [
            'client_request_id'          => '[[CLIENT_REQUEST_ID]]',
            'original_client_request_id' => '[[ORIGINAL_CLIENT_REQUEST_ID]]',
            'brand'                      => '[[BRAND]]',
            'face_value'                 => [
                'amount'   => '[[FACE_VALUE_AMOUNT]]',
                'currency' => '[[FACE_VALUE_CURRENCY]]',
            ],
            'code'                       => '[[CODE]]',
            'pin'                        => '[[PIN]]',
            'sector'                     => 'voluntary-benefits',
            'tags'                       => ['premium', 'lifetime'],
        ];

//        $response = $this->physicalCard->cancel($params);

    }

    /**
     * @doesNotPerformAssertions
     */
    public function testTopUp()
    {
        $params = [
            'client_request_id' => '[[CLIENT_REQUEST_ID]]',
            'brand'             => 'halfords',
            'face_value'        => [
                'amount'   => 10,
                'currency' => 'GBP',
            ],
            'code'              => '5045075881749922012',
            'sector'            => 'voluntary-benefits',
            'tags'              => ['premium', 'lifetime'],
        ];

//        $response = $this->physicalCard->topUp($params);

    }

    /**
     * @doesNotPerformAssertions
     */
    public function testTopUpCancel()
    {
        $params = [
            'client_request_id'          => '[[CLIENT_REQUEST_ID]]',
            'original_client_request_id' => '[[ORIGINAL_CLIENT_REQUEST_ID]]',
            'brand'                      => 'halfords',
            'face_value'                 => [
                'amount'   => 50,
                'currency' => 'GBP',
            ],
            'code'                       => '5045075881749921535',
            'pin'                        => '7721',
            'sector'                     => 'voluntary-benefits',
            'tags'                       => ['premium', 'lifetime'],
        ];

//        $response = $this->physicalCard->topUpCancel($params);


    }


    /**
     * @doesNotPerformAssertions
     */
    public function testCashOut()
    {
        $params = [
            'client_request_id'          => '[[CLIENT_REQUEST_ID]]',
            'original_client_request_id' => '[[ORIGINAL_CLIENT_REQUEST_ID]]',
            'brand'                      => 'halfords',
            'code'                       => '5045075881749922012',
            'pin'                        => '7721',
            'sector'                     => 'voluntary-benefits',
        ];

//        $response = $this->physicalCard->cashOut($params);

    }

    /**
     * * @doesNotPerformAssertions
     */
    public function testOrder()
    {
        $params = [
            'client_request_id'     => '[[CLIENT_REQUEST_ID]]',
            'brand'                 => 'halfords',
            'face_value'            => [
                'amount'   => 20,
                'currency' => 'GBP',
            ],
            'shipping_method'       => 'standard',
            'fulfilment_by'         => 'rewardcloud',
            'fulfilment_parameters' => [
                'to_name'      => 'Receiver Name',
                'company_name' => 'Reward Cloud',
                'address_1'    => '45 Church Road',
                'address_2'    => '',
                'address_3'    => '',
                'address_4'    => '',
                'city'         => 'Hove',
                'postal_code'  => 'BN3 2BE',
                'country'      => 'United Kingdom',
            ],
            'personalisation'       => [
                'message' => 'Here is your requested gift card',
            ],
            'sector'                => 'voluntary-benefits',
            'tags'                  => ['one', 'two'],
        ];

//        $reponse = $this->physicalCard->order($params);

    }


    /**
     * @doesNotPerformAssertions
     */
    public function testOrderStatus()
    {
        $params = [
            'references' => [
                'this-does-not-exist',
                'ab337240-e731-11e8-b7dc-8d2baaa618cb',
            ],
        ];

//        $reponse = $this->physicalCard->orderStatus($params);

    }

    /**
     * @doesNotPerformAssertions
     */
    public function testFulfil()
    {
        $params = [
            'brand'             => '[[BRAND]]',
            'client_request_id' => '[[CLIENT_REQUEST_ID]]',
            'code'              => '5045075881749921691',
            'face_value'        => [
                'amount'   => '[[FACE_VALUE_AMOUNT]]',
                'currency' => '[[FACE_VALUE_CURRENCY]]',
            ],
            'reference'         => 'a9cc4820-de83-11e8-a2fb-5dd310db76de',
        ];

//        $response = $this->physicalCard->fulfil($params);

    }

    /**
     * @doesNotPerformAssertions
     */
    public function testBalance()
    {
        $params = [
            'client_request_id' => '[[CLIENT_REQUEST_ID]]',
            'brand'             => '[[BRAND]]',
            'face_value'        => [
                'currency' => '[[FACE_VALUE_CURRENCY]]',
            ],
            'code'              => '[[CODE]]',
            'pin'               => '[[PIN]]',
            'sector'            => 'voluntary-benefits',
        ];

//        $response = $this->physicalCard->balance($params);

    }


}
