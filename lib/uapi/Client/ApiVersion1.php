<?php

namespace APIuCoz\Client;

use APIuCoz\Methods\V1;


class ApiVersion1 extends AbstractLoader
{
    /**
     * Init version based client
     *
     * @param string $site    site code
     * @param array $params   oauth params
     * @param array $secrets  oauth secrets
     * @param string $version api version
     *
     */
    public function __construct($site, $params, $secrets, $version)
    {
        parent::__construct($site, $params, $secrets, $version);
    }

    use V1\Users;
    use V1\Products;
    use V1\Orders;
}