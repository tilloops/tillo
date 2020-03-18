<?php

namespace RewardCloud;

use Closure;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\RequestInterface;
use function array_slice;
use function GuzzleHttp\choose_handler;

/**
 * Class HttpClient.
 */
class HttpClient
{
    /**
     * @var string The API key to be used for requests.
     */
    private $apiKey;
    /**
     * @var string The API key to be used for requests.
     */
    private $apiSecret;
    /**
     * @var string The base URL for the API.
     */
    private $apiBase;
    /**
     * @var null|string The version of the API to use for requests.
     */
    private $apiVersion;

    /**
     * @var Client
     */
    private $httpClient;

    /**
     * @var Request
     */
    public $lastRequest;

    /**
     * @var Response
     */
    public $lastResponse;

    /**
     * ApiGeneral constructor.
     *
     * @param  array  $settings
     */
    public function __construct(array $settings)
    {
        $this->apiKey     = $settings['apiKey'];
        $this->apiSecret  = $settings['apiSecret'];
        $this->apiBase    = $settings['apiBase'];
        $this->apiVersion = $settings['apiVersion'];

        $this->httpClient = new Client($this->clientConfig());
    }

    /**
     * @return array
     */
    private function clientConfig()
    {
        $stack = new HandlerStack();
        $stack->setHandler(choose_handler());
        $stack->push(Middleware::mapRequest(Closure::fromCallable([$this, 'generateSignature'])));

        return [
            'verify'      => false,
            'http_errors' => false,
            // Base URI is used with relative requests
            'base_uri'    => $this->getBaseUrl(),
            'handler'     => $stack,
            'headers'     => [
                'Content-Type' => 'application/json',
                'Accept'       => 'application/json',
                'API-Key'      => $this->apiKey,
                'Signature'    => null,
                'Timestamp'    => null,
            ],
        ];
    }

    /**
     * @param  RequestInterface  $request
     *
     * @return RequestInterface
     */
    private function generateSignature(RequestInterface $request)
    {
        $method     = $request->getMethod();
        $jsonParams = $request->getBody()->getContents();
        if ($jsonParams) {
            $fieldsParams = json_decode($jsonParams, true);
        } else {
            $implodeQueryString = function ($query) {
                if ($query === '') {
                    return [];
                }
                $queryParams = [];
                foreach (explode('&', $query) as $part) {
                    $queryStr = explode('=', $part);
                    $key      = rawurldecode(reset($queryStr));
                    $part     = rawurldecode(end($queryStr));

                    $queryParams[$key] = $part;
                }

                return $queryParams;
            };

            $fieldsParams = $implodeQueryString($request->getUri()->getQuery());
        }

        $path = explode('/', $request->getUri()->getPath());
        $path = array_slice($path, 3);
        $path = implode('-', $path);

        $timestamp = round(microtime(true) * 1000);

        if ('GET' == $method) {
            $brand = null;

            if (array_key_exists('brand', $fieldsParams)) {
                $brand = $fieldsParams['brand'];
            }

            $requestData = [$brand, $timestamp];
        } else {
            $clientRequestId = $fieldsParams['client_request_id'] ?? null;
            $brand           = $fieldsParams['brand'] ?? null;
            $currencyIsoCode = $fieldsParams['face_value']['currency'] ?? null;
            $faceValueAmount = $fieldsParams['face_value']['amount'] ?? null;

            $requestData = [$clientRequestId, $brand, $currencyIsoCode, $faceValueAmount, $timestamp];
        }

        $signature = [
            $request->getHeader('API-Key')[0],
            $method,
            $path,
        ];

        $signature = array_merge($signature, array_filter($requestData));
        $signature = implode('-', $signature);

        $signature = hash_hmac('sha256', $signature, $this->apiSecret);

        $request = $request->withHeader('Signature', $signature);
        $request = $request->withHeader('Timestamp', $timestamp);

        $this->lastRequest = $request;

        return $request;
    }

    /**
     * @return string
     */
    private function getBaseUrl()
    {
        return sprintf('%s/api/%s/', rtrim(RewardCloud::$apiBase, '/\\'), RewardCloud::$apiVersion);
    }

    /**
     * @param  string  $uri
     * @param  array   $params
     *
     * @return mixed|string
     */
    public function post(string $uri, array $params)
    {
        $response = $this->call($uri, ['form_params' => $params], 'POST');

        return $response;
    }

    /**
     * @param          $uri
     * @param  array   $params
     * @param  string  $method
     *
     * @return mixed|string
     */
    public function call($uri, $params = [], $method = 'GET')
    {
        try {
            $this->lastResponse = $this->httpClient->request($method, $uri, $params);

            $response = json_decode($this->lastResponse->getBody()->getContents(), true);
        } catch (GuzzleException $e) {
            var_dump($e);
            $response = $e->getMessage();
        }

        return $response;
    }

    /**
     * @param  string  $uri
     * @param  array   $params
     *
     * @return mixed|string
     */
    public function postJson(string $uri, array $params)
    {
        $response = $this->call($uri, ['json' => $params], 'POST');

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
        $response = $this->call($uri, ['query' => $params], 'GET');

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
        $response = $this->call($uri, ['form_params' => $params], 'DELETE');

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
        $response = $this->call($uri, ['json' => $params], 'DELETE');

        return $response;
    }


}
