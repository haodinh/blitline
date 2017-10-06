<?php

namespace Haodinh\Blitline\Collection;

use Haodinh\Blitline\BlitlineJob;

/**
 * Jobs collection
 *
 * @author haodinh
 */
class JobsCollection extends ArrayCollection
{

    /**
     * {@inheritdoc}
     */
    public function __construct(array $items = [])
    {
        parent::__construct([]);
        $this->addJobs($items);
    }

    /**
     * Add jobs
     *
     * @param array $jobs
     * @return JobsCollection
     */
    public function addJobs(array $jobs)
    {
        foreach ($jobs as $job) {

            $object = $job instanceof BlitlineJob ? $job : new BlitlineJob($job);

            $this->add($object);
        }

        return $this;
    }
}
