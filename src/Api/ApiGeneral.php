<?php

namespace RewardCloud\Api;

use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use RewardCloud\HttpClient;

abstract class ApiGeneral
{
    /**
     * @var HttpClient
     */
    protected $httpClient;

    /**
     * @var Request;
     */
    public $lastRequest;

    /**
     * @var Response;
     */
    public $lastResponse;

    /**
     * ApiGeneral constructor.
     *
     * @param  array  $settings
     */
    public function __construct(array $settings)
    {
        $this->httpClient = new HttpClient($settings);
    }


    /**
     * @param  string  $uri
     * @param  array   $params
     *
     * @return mixed|string
     */
    public function postJson(string $uri, array $params)
    {
        $response = $this->httpClient->postJson($uri, $params);

        $this->lastRequest  = $this->httpClient->lastRequest;
        $this->lastResponse = $this->httpClient->lastResponse;

        return $response;
    }

    /**
     * @param  string  $uri
     * @param  array   $params
     *
     * @return mixed|string
     */
    public function get(string $uri, array $params = [])
    {
        $response = $this->httpClient->get($uri, $params);

        $this->lastRequest  = $this->httpClient->lastRequest;
        $this->lastResponse = $this->httpClient->lastResponse;

        return $response;
    }

    /**
     * @param  string  $uri
     * @param  array   $params
     *
     * @return mixed|string
     */
    public function delete(string $uri, array $params)
    {
        $response = $this->httpClient->delete($uri, $params);

        $this->lastRequest  = $this->httpClient->lastRequest;
        $this->lastResponse = $this->httpClient->lastResponse;

        return $response;
    }

    /**
     * @param  string  $uri
     * @param  array   $params
     *
     * @return mixed|string
     */
    public function deleteJson(string $uri, array $params)
    {
        $response = $this->httpClient->deleteJson($uri, $params);

        $this->lastRequest  = $this->httpClient->lastRequest;
        $this->lastResponse = $this->httpClient->lastResponse;

        return $response;
    }

    /**
     * @return Response
     */
    public function getResponse()
    {
        return $this->lastResponse;
    }

    /**
     * @return Request
     */
    public function getRequest()
    {
        return $this->lastRequest;
    }
}