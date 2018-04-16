<?php

namespace APIuCoz\Methods\V1;


trait Currency
{
    public function currenciesList()
    {
        return $this->client->makeRequest(
            '/shop/getshopdata',
            "GET",
            array('page' => 'currencies_list')
        );
    }

    public function currencyUpdate($currencyCode, $currencyRate)
    {
        if (!isset($currencyCode) || !isset($currencyRate)) {
            throw new \InvalidArgumentException(
                'Parameters `$currencyCode` and `currencyRate` must contains a data'
            );
        }

        return $this->client->makeRequest(
            '/shop/getshopdata',
            "GET",
            array('curr_code' => $currencyCode, 'curr_rate' => $currencyRate)
        );
    }
}