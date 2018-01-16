<?php

namespace APIuCoz;

use APIuCoz\Client\ApiVersion1;

class ApiClient
{
    public $request;
    private $version;

    const V1 = 'v1';

    /**
     * Init version based client. Visit http://api.ucoz.net/ru/join/reg to create new application and register it's token
     *
     * @param string $site              site url
     * @param string $consumer_key      consumer key
     * @param string $consumer_secret   consumer secret
     * @param string $token             token
     * @param string $token_secret      token_secret
     * @param string $version           api version
     *
     */
    public function __construct($site, $consumer_key, $consumer_secret, $token, $token_secret, $version = self::V1)
    {
        $params = array(
            'oauth_version' =>  '1.0',
            'oauth_timestamp' => time(),
            'oauth_signature_method' => 'HMAC-SHA1',
            'oauth_consumer_key' => $consumer_key,
            'oauth_token' => $token,
        );
        $secrets = array(
            'consumer'  => $consumer_secret,
            'token'  => $token_secret,
        );

        $this->version = $version;
        switch ($version) {
            case self::V1:
                $this->request = new ApiVersion1($site, $params, $secrets, $version);
        }
    }

    /**
     * Get API version
     *
     * @return string
     */
    public function getVersion()
    {
        return $this->version;
    }
}