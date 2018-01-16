<?php


namespace APIuCoz\Http;

use APIuCoz\Exception\CurlException;
use APIuCoz\Exception\InvalidJsonException;
use APIuCoz\Response\ApiResponse;

class Client
{
    const METHOD_GET = 'GET';
    const METHOD_POST = 'POST';
    const METHOD_PUT = 'PUT';
    const METHOD_DELETE = 'DELETE';

    protected $site;
    protected $defaultParameters;
    protected $secrets;

    /**
     * Client constructor.
     *
     * @param string $site              api url
     * @param array  $defaultParameters array of parameters
     *
     */
    public function __construct($site, array $defaultParameters = [], $secrets)
    {
        $this->site = $site;
        $this->defaultParameters = $defaultParameters;
        $this->secrets = $secrets;
    }

    /**
     * Make HTTP request
     *
     * @param string $path      request url
     * @param string $method    (default: 'GET')
     * @param array  $params    (default: array())
     *
     * @throws \InvalidArgumentException
     * @throws CurlException
     * @throws InvalidJsonException
     *
     * @return ApiResponse
     */
    public function makeRequest(
        $path,
        $method,
        array $params = []
    ) {
        $allowedMethods = [self::METHOD_GET, self::METHOD_POST, self::METHOD_PUT, self::METHOD_DELETE];

        if (!in_array($method, $allowedMethods, false)) {
            throw new \InvalidArgumentException(
                sprintf(
                    'Method "%s" is not valid. Allowed methods are %s',
                    $method,
                    implode(', ', $allowedMethods)
                )
            );
        }

        $this->defaultParameters['oauth_nonce'] = md5(microtime() . mt_rand());
        $params = array_merge($this->defaultParameters, $params);

        $url = $this->site. 'uapi' . trim(strtolower($path), '') . '';

        $curlHandler = curl_init();

        switch ($method) {
            case self::METHOD_GET: {
                if ($method && count($params)) {
                    $url .= '?' . http_build_query($params + array('oauth_signature' => $this->getSignature($method, $url, $params)));
                }
                break;
            }
            case self::METHOD_POST: {
                // TODO add POST methods
                //curl_setopt($curlHandler, CURLOPT_POST, true);
                //curl_setopt($curlHandler, CURLOPT_POSTFIELDS, $params);
                throw new \InvalidArgumentException(
                    sprintf(
                        'Method "%s" is not valid. Allowed methods are %s',
                        $method,
                        implode(', ', $allowedMethods)
                    )
                );
                break;
            }
            case self::METHOD_PUT: {
                // TODO add PUT methods
                throw new \InvalidArgumentException(
                    sprintf(
                        'Method "%s" is not valid. Allowed methods are %s',
                        $method,
                        implode(', ', $allowedMethods)
                    )
                );
                break;

            }
            case self::METHOD_DELETE: {
                // TODO add DELETE methods
                throw new \InvalidArgumentException(
                    sprintf(
                        'Method "%s" is not valid. Allowed methods are %s',
                        $method,
                        implode(', ', $allowedMethods)
                    )
                );
            }
        }

        curl_setopt($curlHandler, CURLOPT_URL, $url);
        curl_setopt($curlHandler, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curlHandler, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($curlHandler, CURLOPT_FAILONERROR, false);
        curl_setopt($curlHandler, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curlHandler, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curlHandler, CURLOPT_TIMEOUT, 30);
        curl_setopt($curlHandler, CURLOPT_CONNECTTIMEOUT, 30);

        $responseBody = curl_exec($curlHandler);
        $statusCode = curl_getinfo($curlHandler, CURLINFO_HTTP_CODE);
        $errno = curl_errno($curlHandler);
        $error = curl_error($curlHandler);

        curl_close($curlHandler);

        if ($errno) {
            throw new CurlException($error, $errno);
        }

        return new ApiResponse($statusCode, $responseBody);
    }

    /**
     * Create request sign
     * @param string $method    request method
     * @param string $url       api url
     * @param array  $params
     * @return string
     */
    private function getSignature($method, $url, $params) {
        ksort($params);
        $baseString = strtoupper($method) . '&' . urlencode($url) . '&' . urlencode(strtr(http_build_query($params), array ('+' => '%20')));
        return urlencode(base64_encode(hash_hmac('sha1', $baseString, $this->secrets['consumer'] . '&' . $this->secrets['token'], true)));
    }
}