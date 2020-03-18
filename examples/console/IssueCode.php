<?php
#!/usr/local/bin/php

/**
 * How to use:
 *
 * From your terminal do
 * php examples/console/IssueCode.php --apiKey=xxxxxxx --apiSecret=xxxxxxx --apiBase=xxxxxxx --brand=xxxxxxx
 * --amount=xx.xx
 */


use RewardCloud\RewardCloud;

require_once '../../vendor/autoload.php';

/*
 * Params
 */
$shortOpts = "k:"; //ApiKey
$shortOpts .= "s:"; //ApiSecret
$shortOpts .= "u:"; //ApiBase url
$shortOpts .= "b:"; //brand
$shortOpts .= "a:"; //amount
$shortOpts .= "d::"; //delivery_method

$longOpts = [
    'apiKey:',
    'apiSecret:',
    'apiBase:',
    'brand:',
    'amount:',
    'delivery-method::',
];
$optInd   = null;
$options  = getopt($shortOpts, $longOpts, $optInd);

$parameters = validateInputs($options);

$apiKey    = $parameters['apiKey'];
$apiSecret = $parameters['apiSecret'];
$apiBase   = $parameters['apiBase'];

$rc = new RewardCloud($apiKey, $apiSecret, $apiBase);

$issueDigitalCode = [
    'brand'                 => $parameters['brand'],
    'client_request_id'     => time(),
    'delivery_method'       => $parameters['delivery_method'] ?? 'code',
    'face_value'            => [
        'amount'   => $parameters['amount'],
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
];

$response = $rc->digitalCode->issue($issueDigitalCode);

if (array_key_exists('error', $response)) {
    echo 'Error';
    var_dump($response['error']);
    die;
}

$httpRequest = $rc->digitalCode->getRequest();
$httpHeaders = $httpRequest->getHeaders();
$gf          = $response['data'];


$signature = [
    'apiKey'            => $httpHeaders['API-Key'][0],
    'method'            => $httpRequest->getMethod(),
    'path'              => implode('-', array_slice(explode('/', $httpRequest->getUri()->getPath()), 3)),
    'client_request_id' => $issueDigitalCode['client_request_id'],
    'brand'             => $issueDigitalCode['brand'],
    'currency'          => $issueDigitalCode['face_value']['currency'],
    'amount'            => $issueDigitalCode['face_value']['amount'],
    'timestamp'         => $httpHeaders['Timestamp'][0],
];
echo PHP_EOL;
echo PHP_EOL;
echo 'Signature parameters' . PHP_EOL;
echo PHP_EOL;
echo sprintf('Api Key           : %s' . PHP_EOL, $signature['apiKey']);
echo sprintf('Method            : %s' . PHP_EOL, $signature['method']);
echo sprintf('Path              : %s' . PHP_EOL, $signature['path']);
echo sprintf('Client request id : %s' . PHP_EOL, $signature['client_request_id']);
echo sprintf('Brand             : %s' . PHP_EOL, $signature['brand']);
echo sprintf('Currency          : %s' . PHP_EOL, $signature['currency']);
echo sprintf('Amount            : %s' . PHP_EOL, $signature['amount']);
echo sprintf('Timestamp         : %s' . PHP_EOL, $signature['timestamp']);
echo PHP_EOL;
echo sprintf('Raw signature     : %s' . PHP_EOL, implode('-', $signature));
echo sprintf('Request signature : %s' . PHP_EOL, $httpHeaders['Signature'][0]);
echo PHP_EOL;
echo PHP_EOL;
echo 'Success to issue the code' . PHP_EOL;
echo $response['message'] . PHP_EOL;
echo PHP_EOL;
echo sprintf('Brand             : %s' . PHP_EOL, $gf['brand']);
echo sprintf('Amount            : %01.2f %s ' . PHP_EOL, $gf['face_value']['amount'], $gf['face_value']['currency']);
echo sprintf('Code              : %s' . PHP_EOL, $gf['code']);
echo PHP_EOL;
echo sprintf('Expiration        : %s' . PHP_EOL, date('d/m/Y H:i', strtotime($gf['expiration_date'])));
echo PHP_EOL . PHP_EOL;


function validateInputs(array $inputs)
{
    $eg = 'eg: cliScript.php -k|--apiKey=key -s|--apiSecret=secret -u|--apiBase=uri -b|--brand=brand -a|--amount=amount [-d|--delivery-method=delivery-method]';
    if (!count($inputs)) {
        echo 'Something went wrong, we cannot find any parameters.' . PHP_EOL . $eg;

        die;
    }

    $validateField = function ($shortField, $longField) use ($inputs, $eg) {
        if (!array_key_exists($shortField, $inputs) && !array_key_exists($longField, $inputs)) {
            echo "Error: {$longField} not defined" . PHP_EOL . $eg;
            die;
        }

        return $inputs[$shortField] ?? $inputs[$longField];
    };

    $parameters = [];

    $parameters['apiKey']          = $validateField('k', 'apiKey');
    $parameters['apiSecret']       = $validateField('s', 'apiSecret');
    $parameters['apiBase']         = $validateField('u', 'apiBase');
    $parameters['brand']           = $validateField('b', 'brand');
    $parameters['amount']          = $validateField('a', 'amount');
    $parameters['delivery_method'] = $inputs['delivery-method'] ?? $inputs['d'] ?? null;

    return $parameters;
}

