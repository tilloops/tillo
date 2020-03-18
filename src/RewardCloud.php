<?php

namespace RewardCloud;


use RewardCloud\Api\Brand;
use RewardCloud\Api\BrandTemplate;
use RewardCloud\Api\DigitalCode;
use RewardCloud\Api\PhysicalCard;

/**
 * Class RewardCloud
 *
 * @property DigitalCode   $digitalCode
 * @property PhysicalCard  $physicalCard
 * @property Brand         $brand
 * @property BrandTemplate $template
 *
 *
 * @package RewardCloud
 */
class RewardCloud
{
    const VERSION = '1.00.0';
    /**
     * @var string The API key to be used for requests.
     */
    public static $apiKey;
    /**
     * @var string The API key to be used for requests.
     */
    public static $apiSecret;
    /**
     * @var string The base URL for the API.
     */
    public static $apiBase;
    /**
     * @var string|null The version of the API to use for requests.
     */
    public static $apiVersion = 'v2';
    /**
     * @var DigitalCode
     */
    public $digitalCode;

    /**
     * @var PhysicalCard
     */
    public $physicalCard;

    /**
     * @var Brand
     */
    public $brand;

    /**
     * @var BrandTemplate
     */
    public $template;

    /**
     * RewardCloud constructor.
     *
     * @param        $apiKey
     * @param        $apiSecret
     * @param  null  $apiBase
     * @param  null  $apiVersion
     */
    public function __construct($apiKey = null, $apiSecret = null, $apiBase = null, $apiVersion = null)
    {
        self::$apiKey     = $apiKey ?? self::$apiKey;
        self::$apiSecret  = $apiSecret ?? self::$apiSecret;
        self::$apiBase    = $apiBase ?? self::$apiBase;
        self::$apiVersion = $apiVersion ?? self::$apiVersion;

        $this->instantiate();
    }

    /**
     * @return void
     */
    protected function instantiate()
    {
        $this->digitalCode  = new DigitalCode($this->settings());
        $this->physicalCard = new PhysicalCard($this->settings());
        $this->brand        = new Brand($this->settings());
        $this->template     = new BrandTemplate($this->settings());
    }

    /**
     * @return array
     */
    private function settings()
    {
        return [
            'apiKey'     => self::$apiKey,
            'apiSecret'  => self::$apiSecret,
            'apiBase'    => self::$apiBase,
            'apiVersion' => self::$apiVersion,
        ];
    }


}