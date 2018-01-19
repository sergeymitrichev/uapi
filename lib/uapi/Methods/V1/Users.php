<?php

namespace APIuCoz\Methods\V1;

trait Users
{
    /**
     * Returns filtered users list
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
    public function usersList(array $filter = [], $page = null, $limit = null)
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
            '/users',
            "GET",
            $parameters
        );
    }
    /**
     * Create a user
     *
     * @param array  $user user data
     *
     * @throws \InvalidArgumentException
     * @throws \APIuCoz\Exception\CurlException
     * @throws \APIuCoz\Exception\InvalidJsonException
     *
     * @return \APIuCoz\Response\ApiResponse
     */
    public function usersCreate(array $user)
    {
        if (! count($user)) {
            throw new \InvalidArgumentException(
                'Parameter `customer` must contains a data'
            );
        }

        return $this->client->makeRequest(
            '/users',
            "POST",
            $user
        );
    }

    /**
     * Get a user by ID
     *
     * @param int  $userId user ID
     *
     * @throws \InvalidArgumentException
     * @throws \APIuCoz\Exception\CurlException
     * @throws \APIuCoz\Exception\InvalidJsonException
     *
     * @return \APIuCoz\Response\ApiResponse
     */
    public function usersGetById(int $userId)
    {
        if (!isset($userId)) {
            throw new \InvalidArgumentException(
                'Parameter `customer` must contains a data'
            );
        }

        return $this->client->makeRequest(
            '/users',
            "GET",
            array('user_id' =>  $userId)
        );
    }

    /**
     * Get a user by login
     *
     * @param string  $userLogin user login
     *
     * @throws \InvalidArgumentException
     * @throws \APIuCoz\Exception\CurlException
     * @throws \APIuCoz\Exception\InvalidJsonException
     *
     * @return \APIuCoz\Response\ApiResponse
     */
    public function usersGetByLogin(string $userLogin)
    {
        if (!isset($userLogin)) {
            throw new \InvalidArgumentException(
                'Parameter `customer` must contains a data'
            );
        }

        return $this->client->makeRequest(
            '/users',
            "GET",
            array('user' =>  $userLogin)
        );
    }

}