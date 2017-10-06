<?php

namespace Haodinh\Blitline;

use Haodinh\Blitline\Collection\JobsCollection;

/**
 * Blitline pre process
 *
 * @author haodinh
 */
class BlitlinePreProcess
{
    /**
     * @var JobsCollection
     */
    protected $jobs;

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

        $jobs = [];

        foreach ($this->getJobs() as $job) {
            $jobs[] = ['job' => $job()];
        }

        return $jobs ? ['pre_process' => $jobs] : $jobs;
    }

    /**
     * Config
     *
     * @param array $config
     * @return BlitlineJob
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
     * Set jobs
     *
     * @param JobsCollection|array $jobs
     * @return BlitlinePreProcess
     */
    public function setJobs($jobs)
    {
        $this->jobs = $jobs instanceof JobsCollection ? $jobs : new JobsCollection($jobs);

        return $this;
    }

    /**
     * Get jobs
     *
     * @return JobsCollection
     */
    public function getJobs()
    {
        if (!$this->jobs instanceof JobsCollection) {
            $this->jobs = new JobsCollection;
        }

        return $this->jobs;
    }
}
