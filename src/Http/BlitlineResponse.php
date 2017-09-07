<?php

namespace Haodinh\Blitline\Http;

use GuzzleHttp\Psr7\Response as GuzzleResponse;

/**
 * Blitline response
 */
class BlitlineResponse
{
    /**
     * @var int
     */
    protected $statusCode;

    /**
     * @var array
     */
    protected $headers;

    /**
     * @var array
     */
    protected $body;

    /**
     * Create instance from guzzle response
     * 
     * @param GuzzleResponse $response
     * @return BlitlineResponse
     */
    public static function create(GuzzleResponse $response)
    {
        return new static(self::getInfoGuzzleResponse($response));
    }

    /**
     * Get info guzzle reponse
     * 
     * @param GuzzleResponse $response
     * @return array
     */
    public static function getInfoGuzzleResponse(GuzzleResponse $response)
    {
        $config = [
            'statusCode' => $response->getStatusCode(),
            'headers'    => $response->getHeaders()
        ];

        $body = (string) $response->getBody();

        if ($body) {
            $config['body'] = json_decode($body, true);
        }

        return $config;
    }

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
            'statusCode' => $this->getStatusCode(),
            'headers'    => $this->getHeaders(),
            'body'       => $this->getBody()
        ];
    }

    /**
     * Config
     * 
     * @param array $config
     * @return BlitlineResposne
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
     * Set status code
     * 
     * @param int $statusCode
     * @return BlitlineResponse
     */
    public function setStatusCode(int $statusCode)
    {
        $this->statusCode = $statusCode;

        return $this;
    }

    /**
     * Get status code
     *
     * @return int
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * Set headers
     * 
     * @param array $headers
     * @return BlitlineResponse
     */
    public function setHeaders(array $headers)
    {
        $this->headers = $headers;

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
     * Set body
     * 
     * @param array $body
     * @return BlitlineResponse
     */
    public function setBody(array $body)
    {
        $this->body = $body;

        return $this;
    }

    /**
     * Get body
     *
     * @return array
     */
    public function getBody()
    {
        return $this->body;
    }
}
