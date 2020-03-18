<?php

use RewardCloud\RewardCloud;

$rc = new RewardCloud($apiKey, $apiSecret, $apiBase);

$params = [];

$response = $rc->digitalCode->issue($params);
$response = $rc->digitalCode->cancel($params);
$response = $rc->digitalCode->reverse($params);
$response = $rc->digitalCode->cashOut($params);
$response = $rc->digitalCode->checkStock($params);
$response = $rc->digitalCode->checkBalance($params);

$response = $rc->physicalCard->order($params);
$response = $rc->physicalCard->orderStatus($params);
$response = $rc->physicalCard->activate($params);
$response = $rc->physicalCard->cancel($params);
$response = $rc->physicalCard->balance($params);
$response = $rc->physicalCard->cashOut($params);
$response = $rc->physicalCard->fulfil($params);
$response = $rc->physicalCard->topUp($params);
$response = $rc->physicalCard->topUpCancel($params);

$response = $rc->brand->list($params);
$response = $rc->brand->checkFloat($params);

$response = $rc->template->list($params);
$response = $rc->template->request($params);