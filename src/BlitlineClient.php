<?php

namespace Haodinh\Blitline;

use GuzzleHttp\Client as GuzzleClient;
use Haodinh\Blitline\BlitlineApp;
use Haodinh\Blitline\BlitlineJob;
use Haodinh\Blitline\BlitlineOptions;
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
     * @var BlitlineJob
     */
    protected $job;

    /**
     * @var BlitlineOptions
     */
    protected $options;

    /**
     * @var GuzzleClient
     */
    protected $http;

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
        if (!$this->job instanceof BlitlineJob) {
            $this->job = new BlitlineJob;
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
	 * @param  BlitlineRequest $request
     * @param  BlitlineResponse $response
     * @return bool
     */
    public function process(BlitlineRequest &$request = null, BlitlineResponse &$response = null)
    {
		if (!$request) {
			$request = new BlitlineRequest(['json' => $this()]);
		}

        $this->getHttp()->request($request, $response);

        $results = $response->getBody()['results'] ?? null;

        if (!$results || !$images = $results['images'] ?? null) {
            return false;
        }

        $job = $this->getJob();

        $job->setJobId($results['job_id']);
		
		$funcs = $job->getFunctions();
		
		foreach ($images as $index => $image) {
			if ($func = $funcs->get($index)) {
				$func->getImage()->setSrc($images[$index]['s3_url']);
			}
        }
		
		return true;
    }
}
