<?php

namespace APIuCoz\Client;

use APIuCoz\Http\Client;

class AbstractLoader
{
    protected $client;

    /**
     * Init version based client
     *
     * @param string $site    site code
     * @param array $params  oauth deny params
     * @param string $version api version
     */
    public function __construct($site, $params, $secrets, $version)
    {
        // TODO remove '/' at the end of site url
        //if ('/' == $site[strlen($site) - 1]) {}
        if (empty($version) || !in_array($version, ['v1'])) {
            throw new \InvalidArgumentException(
                'Version parameter must be not empty and must be equal one of v1'
            );
        }
        $this->client = new Client($site, $params, $secrets);
    }
}