<?php

namespace Draguo\Dingtalk\Supports;

use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;

trait HasHttpRequest
{

    /**
     * @param string $endpoint
     * @param array $query
     * @param array $headers
     *
     * @return array|string
     */
    protected function get($endpoint, $query = [], $headers = [])
    {
        return $this->request('get', $endpoint, [
            'headers' => $headers,
            'query' => $query,
        ]);
    }

    /**
     *
     * @param string $endpoint
     * @param string|array $data
     * @param array $options
     *
     * @return array|string
     */
    protected function post($endpoint, $data, $options = [])
    {
        if (!is_array($data)) {
            $options['body'] = $data;
        } else {
            $options['form_params'] = $data;
        }

        return $this->request('post', $endpoint, $options);
    }

    protected function postJson($endpoint, $data, $options = [])
    {
        $options['json'] = $data;
        return $this->request('post', $endpoint, $options);
    }

    /**
     * send request.
     *
     * @param string $method
     * @param string $endpoint
     * @param array $options
     *
     * @return array|string
     * @throws \Exception
     */
    protected function request($method, $endpoint, $options = [])
    {
        $response = $this->unwrapResponse($this->getHttpClient($this->getBaseOptions())->{$method}($endpoint, $options));
        if ($response['errcode'] == 0) {
            return $response;
        }
        throw new \Exception($response['errmsg'], $response['errcode']);
    }

    /**
     * @return array
     */
    protected function getBaseOptions()
    {
        return [
            'base_uri' => property_exists($this, 'baseUri') ? $this->baseUri : '',
            'timeout' => property_exists($this, 'timeout') ? $this->timeout : 5.0,
            'connect_timeout' => property_exists($this, 'connectTimeout') ? $this->connectTimeout : 5.0,
        ];
    }

    /**
     * @param array $options
     * @return Client
     */
    protected function getHttpClient(array $options = [])
    {
        return new Client($options);
    }

    /**
     * @param ResponseInterface $response
     * @return mixed|string
     */
    protected function unwrapResponse(ResponseInterface $response)
    {
        $contentType = $response->getHeaderLine('Content-Type');
        $contents = $response->getBody()->getContents();

        if (false !== stripos($contentType, 'json') || stripos($contentType, 'javascript')) {
            return json_decode($contents, true);
        } elseif (false !== stripos($contentType, 'xml')) {
            return json_decode(json_encode(simplexml_load_string($contents, 'SimpleXMLElement', LIBXML_NOCDATA), JSON_UNESCAPED_UNICODE), true);
        }

        return $contents;
    }
}