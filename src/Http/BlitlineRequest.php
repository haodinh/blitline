<?php

namespace Haodinh\Blitline\Http;

/**
 * Blitline request
 */
class BlitlineRequest
{
    /**
     * @var string
     */
    protected $endpoint = 'http://api.blitline.com/job';

    /**
     * @var string
     */
    protected $method = 'POST';

    /**
     * @var array
     */
    protected $headers = [];

    /**
     * @var array
     */
    protected $json = [];

    /**
     * Constructor
     *
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        $this->config($config);
    }

    /**
     * Invoke
     * 
     * @return array
     */
    public function __invoke()
    {
        return [
            $this->getMethod(),
            $this->getEndpoint(),
            [
                'json'    => $this->getJson(),
                'headers' => $this->getHeaders()
            ]
        ];
    }

    /**
     * Config
     * 
     * @param array $config
     * @return BlitlineRequest
     */
    public function config(array $config)
    {
        foreach ($config as $key => $value) {

            $method = 'set' . ucfirst($key);

            if (is_callable([$this, $method])) {
                $this->$method($value);
            }
        }

        return $this;
    }

    /**
     * Set endpoint
     *
     * @param string
     * @return BlitlineRequest
     */
    public function setEndpoint(string $endpoint)
    {
        $this->endpoint = $endpoint;

        return $this;
    }

    /**
     * Get endpoint
     *
     * @return string
     */
    public function getEndpoint()
    {
        return $this->endpoint;
    }

    /**
     * Set method
     *
     * @param string
     * @return BlitlineRequest
     */
    public function setMethod(string $method)
    {
        $this->method = $method;

        return $this;
    }

    /**
     * Get method
     *
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * Set headers
     *
     * @param array
     * @return BlitlineRequest
     */
    public function setHeaders(array $headers)
    {
        $this->headers = array_merge($this->headers, $headers);

        return $this;
    }

    /**
     * Get headers
     *
     * @return array
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * Set json
     *
     * @param array
     * @return BlitlineRequest
     */
    public function setJson(array $json)
    {
        $this->json = array_merge($this->json, $json);

        return $this;
    }

    /**
     * Get json
     * 
     * @return array
     */
    public function getJson()
    {
        return $this->json;
    }
}
