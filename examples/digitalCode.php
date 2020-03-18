<?php

use RewardCloud\RewardCloud;

require_once '../vendor/autoload.php';


$apikey    = 'xxxxxxxxxxxx';
$apiSecret = 'xxxxxxxxxxxx';
$apiBase   = 'https://sandbox.tillo.dev';

$rc = new RewardCloud($apikey, $apiSecret, $apiBase);

$clientRequest    = time();
$issueDigitalCode = [
    'brand'                 => 'tesco',
    'client_request_id'     => $clientRequest,
    'delivery_method'       => 'code',
    'face_value'            => [
        'amount'   => 27,
        'currency' => 'GBP'
    ],
    'fulfilment_by'         => 'rewardcloud',
    'fulfilment_parameters' => [
        'from_email' => 'email@reward.cloud',
        'from_name'  => 'from_name',
        'subject'    => 'Your Gift Card',
        'to_email'   => 'email@reward.cloud',
        'to_name'    => 'emailTo',
    ],
    'personalisation'       => [
        'from_name' => 'From Name',
        'message'   => 'Here is your gift card',
        'template'  => 'standard',
        'to_name'   => 'To Name',
    ],
    'sector'                => 'voluntary-benefits'
];

$response = $rc->digitalCode->issue($issueDigitalCode);
var_dump($response);


$issueData         = $response['data'];
$cancelDigitalCode = [
    'client_request_id'          => time(),
    'original_client_request_id' => $clientRequest,
    'brand'                      => $issueData['brand'],
    'face_value'                 => [
        'amount'   => $issueData['face_value']['amount'],
        'currency' => $issueData['face_value']['currency']
    ],
    'code'                       => $issueData['code'],
    'sector'                     => 'voluntary-benefits',
    'tags'                       => ['premium', 'lifetime']
];

$response = $rc->digitalCode->cancel($cancelDigitalCode);
var_dump($response);


die;