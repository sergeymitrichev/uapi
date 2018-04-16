<?php

namespace APIuCoz\Methods\V1;


trait System
{
    public function ping(array $parameters = [])
    {
        return $this->client->makeRequest(
            '/ping',
            "GET",
            $parameters
        );
    }

    public function getSites()
    {
        return $this->client->makeRequest(
            '/mysites',
            "GET"
        );
    }
}