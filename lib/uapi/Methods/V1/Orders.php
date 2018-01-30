<?php

namespace APIuCoz\Methods\V1;

trait Orders
{
    /**
     * Returns filtered orders list http://api.ucoz.net/ru/manual/shop/orders#one5
     *
     * @param array $filter (default: array())
     * @param int   $page   (default: null)
     * @param int   $limit  (default: null)
     *
     * @throws \InvalidArgumentException
     * @throws \APIuCoz\Exception\CurlException
     * @throws \APIuCoz\Exception\InvalidJsonException
     *
     * @return \APIuCoz\Response\ApiResponse
     */
    public function ordersList(array $filter = [], $page = null, $limit = null)
    {
        $parameters = [];

        if (count($filter)) {
            $parameters['filter'] = $filter;
        }
        if (null !== $page) {
            $parameters['page'] = (int) $page;
        }
        if (null !== $limit) {
            $parameters['limit'] = (int) $limit;
        }

        return $this->client->makeRequest(
            '/shop/invoices',
            "GET",
            $parameters
        );
    }
    /**
     * Create an order
     *
     * @param array  $order user data
     *
     * @throws \InvalidArgumentException
     * @throws \APIuCoz\Exception\CurlException
     * @throws \APIuCoz\Exception\InvalidJsonException
     *
     * @return \APIuCoz\Response\ApiResponse
     */
    public function ordersCreate(array $order)
    {
        if (!count($order)) {
            throw new \InvalidArgumentException(
                'Parameter `orders` must contains a data'
            );
        }

        $order['mode'] = 'order';

        return $this->client->makeRequest(
            '/shop/checkout',
            "POST",
            $order
        );
    }

    /**
     * Update an order
     * Combines two basic uAPI methods:
     * 1) Add products to order (use item ID'S in array $order['ids'])
     * 2) Update price, quantity and remove products from order
     *
     * @param array  $order order data
     *
     * @throws \InvalidArgumentException
     * @throws \APIuCoz\Exception\CurlException
     * @throws \APIuCoz\Exception\InvalidJsonException
     *
     * @return \APIuCoz\Response\ApiResponse
     */
    public function ordersUpdate(array $order)
    {
        if (!count($order)) {
            throw new \InvalidArgumentException(
                'Parameter `order` must contains a data'
            );
        }

        if(!isset($order['order'])) {
            throw new \InvalidArgumentException(
                'Parameter `order` must contains order hash in `order` ($order[`order`] => `order_hash`)'
            );
        }

        if(isset($order['ids'])) {
            $hash = $order['order'];
            foreach ($order['ids'] as $productId) {
                $this->client->makeRequest(
                    '/shop/order',
                    "POST",
                    array('id'  => $productId, 'order' => $hash)
                );
            }
            unset($order['id']);
        }

        return $this->client->makeRequest(
            '/shop/order',
            "PUT",
            $order
        );
    }

    /**
     * Get an order by hash
     *
     * @param string  $hash order hash
     *
     * @throws \InvalidArgumentException
     * @throws \APIuCoz\Exception\CurlException
     * @throws \APIuCoz\Exception\InvalidJsonException
     *
     * @return \APIuCoz\Response\ApiResponse
     */
    public function ordersGet(string $hash)
    {
        if (!isset($hash)) {
            throw new \InvalidArgumentException(
                'Parameter `hash` must contains a data'
            );
        }

        return $this->client->makeRequest(
            '/shop/order',
            "GET",
            array('order' =>  $hash)
        );
    }
}