<?php

namespace Haodinh\Blitline\Service;

use GuzzleHttp\Client as GuzzleClient;
use Haodinh\Blitline\App\BlitlineApp;
use Haodinh\Blitline\Job\BlitlineJob;
use Haodinh\Blitline\Options\BlitlineOptions;
use Haodinh\Blitline\Http\BlitlineHttp;
use Haodinh\Blitline\Http\BlitlineRequest;
use Haodinh\Blitline\Http\BlitlineResponse;

/**
 * Blitline client
 */
class BlitlineClient
{
    /**
     * @var BlitlineApp
     */
    protected $app;

    /**
     * @var GuzzleClient
     */
    protected $http;

    /**
     * @var BlitlineJob
     */
    protected $job;

    /**
     * Constructor
     * 
     * @param array $config
     */
    public function __construct(array $config)
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
        $app = $this->getApp();
        $job = $this->getJob();
        $opt = $this->getOptions();

        return array_merge($app(), $job(), $opt());
    }

    /**
     * Config
     * 
     * @param array $config
     * @return BlitlineOptions
     */
    public function config(array $config)
    {
        foreach ($config as $key => $value) {

            $method = 'get' . ucfirst($key);

            if (is_callable([$this, $method])) {
                $this->$method()->config($value);
            }
        }

        return $this;
    }

    /**
     * Get app
     * 
     * @return BlitlineApp
     */
    public function getApp()
    {
        if (!$this->app instanceof BlitlineApp) {
            $this->app = new BlitlineApp;
        }

        return $this->app;
    }

    /**
     * Get job
     * 
     * @return BlitlineJob
     */
    public function getJob()
    {
        if (!$this->job instanceof BlitlineOptions) {
            $this->job = new BlitlineOptions;
        }

        return $this->job;
    }

    /**
     * Get options
     *
     * @return BlitlineOptions
     */
    public function getOptions()
    {
        if (!$this->options instanceof BlitlineOptions) {
            $this->options = new BlitlineOptions;
        }

        return $this->options;
    }

    /**
     * Get http
     * 
     * @return BlitlineHttp
     */
    public function getHttp()
    {
        if (!$this->http instanceof BlitlineHttp) {
            $this->http = new BlitlineHttp;
        }

        return $this->http;
    }

    /**
     * Process
     * 
     * @return string|null
     */
    public function process()
    {
        $json = $this();

        $request  = new BlitlineRequest(['json' => $json]);
        $response = new BlitlineResponse;

        $this->getHttp()->request($request, $response);

        $results = $response->getBody()['results'];

        if (!$images = $results['images'] ?? null) {
            return $results['error'];
        }

        $job = $this->getJob();

        $job->setJobId($results['job_id']);

        foreach ($job->getFunctions() as $index => $func) {

            $src = $images[$index]['s3_url'];

            $func->getImage()->setSrc($src);
        }
    }
}
