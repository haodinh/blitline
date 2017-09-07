<?php

namespace Haodinh\Blitline\Http;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\RequestException;
use Haodinh\Blitline\Exception\BlitlineException;

/**
 * Blitline http
 */
class BlitlineHttp
{
    /**
     * @var GuzzleClient
     */
    protected $client;

    /**
     * Send request
     *
     * @param  BlitlineRequest $request
     * @param  BlitlineResponse $response
     * @return BlitlineResponse
     */
    public function request(BlitlineRequest $request, BlitlineResponse &$response = null)
    {
        try {
            $guzzleResponse = $this->getClient()->request(...$request());
        } catch (RequestException $ex) {

            $res  = $ex->getResponse();
            $body = (string) $res->getBody();
            $msg  = $body ? (json_decode($body, true)['results'] ?? 'ERROR_OCCURRED') : $ex->getMessage();

            throw new BlitlineException($msg, $res->getStatusCode());
        }

        if (!$response) {
            $response = BlitlineResponse::create($guzzleResponse);
        } else {

            $config = BlitlineResponse::getInfoGuzzleResponse($guzzleResponse);

            $response->config($config);
        }
    }

    /**
     * Get client
     * 
     * @return GuzzleClient
     */
    protected function getClient()
    {
        if (!$this->client instanceof GuzzleClient) {
            $this->client = new GuzzleClient;
        }

        return $this->client;
    }
}
