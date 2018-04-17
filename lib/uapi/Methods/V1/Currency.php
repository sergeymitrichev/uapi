<?php

namespace APIuCoz\Methods\V1;


trait Currency
{
    public function currenciesList()
    {
        return $this->client->makeRequest(
            '/shop/getshopdata/',
            "GET",
            array('page' => 'currencies_list')
        );
    }

    public function currencyUpdate($code, $rate)
    {
        if (!isset($code) || !isset($rate)) {
            throw new \InvalidArgumentException(
                'Parameters `$code` and `$rate` must contains a data'
            );
        }

        return $this->client->makeRequest(
            '/shop/setcurrrate',
            "POST",
            array('curr_code' => $code, 'curr_rate' => $rate)
        );
    }
}