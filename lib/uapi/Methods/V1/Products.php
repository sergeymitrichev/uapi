<?php

namespace APIuCoz\Methods\V1;


trait Products
{
    /**
     * Create a product
     *
     * @param array  $product product data
     *
     * @throws \InvalidArgumentException
     * @throws \APIuCoz\Exception\CurlException
     * @throws \APIuCoz\Exception\InvalidJsonException
     *
     * @return \APIuCoz\Response\ApiResponse
     */
    public function productsCreate(array $product)
    {
        if (!count($product)) {
            throw new \InvalidArgumentException(
                'Parameter `product` must contains a data'
            );
        }

        if (!isset($product['cat_id']) || !isset($product['name'])) {
            throw new \InvalidArgumentException(
                'Parameter `product` must contains a `cat_id` and a `name`'
            );
        }

        return $this->client->makeRequest(
            '/shop/addgoods',
            "POST",
            $product + array('method' => 'submit')
        );
    }

    /**
     * Add image to product by ID
     *
     * @param array $images product images
     * @param string $id product id
     *
     * @return void
     */
    public function productsAddImage(array $images, $id)
    {
        throw new \BadMethodCallException('This activity not allowed');
    }

    public function productsUpdate(array $product)
    {
        if (!count($product)) {
            throw new \InvalidArgumentException(
                'Parameter `product` must contains a data'
            );
        }

        if (!isset($product['cat_id']) || !isset($product['id'])) {
            throw new \InvalidArgumentException(
                'Parameter `product` must contains a `cat_id` and an `id`'
            );
        }

        return $this->client->makeRequest(
            '/shop/editgoods',
            "POST",
            $product + array('method' => 'submit')
        );
    }

    public function productsList(array $filter = [])
    {
        return $this->client->makeRequest(
            '/shop/request',
            "GET",
            $filter + array('page' => 'allgoods')
        );
    }
}