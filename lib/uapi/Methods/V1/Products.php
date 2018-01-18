<?php
/**
 * Created by PhpStorm.
 * User: Anton
 * Date: 18.01.2018
 * Time: 14:34
 */

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
     * @param array  $images product images
     * @param string $id product id
     *
     * @throws \InvalidArgumentException
     * @throws \APIuCoz\Exception\CurlException
     * @throws \APIuCoz\Exception\InvalidJsonException
     *
     * @return \APIuCoz\Response\ApiResponse
     */
    public function productsAddImage(array $images, $id)
    {
        if (!count($images)) {
            throw new \InvalidArgumentException(
                'Parameter `images` must contains at least one image'
            );
        }

        if (!isset($id)) {
            throw new \InvalidArgumentException(
                'Parameter `id` is not set'
            );
        }

        return $this->client->makeRequest(
            '/shop/addgoods',
            "POST",
            $images + array('method' => 'img-add', 'file_add_cnt' => count($images), 'id' => $id)
        );
    }
}