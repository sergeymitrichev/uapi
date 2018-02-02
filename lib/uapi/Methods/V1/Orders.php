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
     * @string $statusId
     * @param string $ids
     * @param $statusId
     * @return mixed
     */
    public function ordersChangeStatus(string $ids = '', string $statusId) {

        if ($ids == '') {
            throw new \InvalidArgumentException(
                'Parameter `ids` must contains a data'
            );
        }

        $params = ['ids' => $ids, 'status' => $statusId, 'mode' => 'status'];

        return $this->client->makeRequest(
            '/shop/invoices/',
            "PUT",
            $params
        );
    }

    /**
     * @param string $orderHash
     * @param string $productId
     * @return mixed
     */
    public function ordersAddItem(string $orderHash, string $productId) {

        if(!isset($orderHash) || !isset($productId)) {
            throw new \InvalidArgumentException(
                'Parameter `orderHash` and `productId` must contains a data'
            );
        }

        $params = ['order' => $orderHash, 'id' => $productId];


        return $this->client->makeRequest(
            '/shop/order/',
            "POST",
            $params
        );
    }

    /**
     * @param string $orderHash
     * @param array $products
     * @return mixed
     */
    public function ordersUpdateItems(string $orderHash, array $products = []) {

        $params = [
            'order' => $orderHash
        ];

        foreach ($products as $pid => $product) {
            if (isset($product['toDelete'])) {
                $params['del_' . $pid] = 1;
                continue;
            }
            if (isset($product['cnt'])) {
                $params['cnt_' . $pid] = $product['cnt'];
            }
            if (isset($product['price'])) {
                $params['price_' . $pid] = $product['price'];
            }
        }

        return $this->client->makeRequest(
            '/shop/order/',
            "POST",
            $params
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