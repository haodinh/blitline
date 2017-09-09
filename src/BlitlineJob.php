<?php

namespace Haodinh\Blitline;

use Haodinh\Blitline\Image\BlitlineImage;
use Haodinh\Blitline\Collection\FunctionsCollection;

/**
 * Blitline Job
 *
 * @author haodinh
 */
class BlitlineJob
{
    /**
     * @var string
     */
    protected $jobId;

    /**
     * @var BlitlineImage
     */
    protected $originImage;

    /**
     * @var string
     */
    protected $functions;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->functions = new FunctionsCollection;
    }

    /**
     * Invoke
     * 
     * @return array
     */
    public function __invoke()
    {
        $result['src'] = $this->getOriginImage()->getSrc();

        foreach ($this->getFunctions() as $func) {
            $result['functions'][] = $func();
        }

        return $result;
    }

    /**
     * Set job id
     *
     * @param string $jobId
     * @return BlitlineJob
     */
    public function setJobId(string $jobId)
    {
        $this->jobId = $jobId;

        return $this;
    }

    /**
     * Get job id
     *
     * @return string
     */
    public function getJobId()
    {
        return $this->jobId;
    }

    /**
     * Set origin image
     * 
     * @param BlitlineImage $image
     * @return BlitlineJob
     */
    public function setOriginImage(BlitlineImage $image)
    {
        $this->originImage = $image;

        return $this;
    }

    /**
     * Get origin image
     * 
     * @return BlitlineImage
     */
    public function getOriginImage()
    {
        if (!$this->originImage instanceof BlitlineImage) {
            $this->originImage = new BlitlineImage;
        }

        return $this->originImage;
    }

    /**
     * Set functions
     *
     * @return FunctionsCollection
     */
    public function setFunctions(FunctionsCollection $functions)
    {
        $this->functions = $functions;

        return $this;
    }

    /**
     * Get functions
     *
     * @return FunctionsCollection
     */
    public function getFunctions()
    {
        if (!$this->functions instanceof FunctionsCollection) {
            $this->functions = new FunctionsCollection;
        }

        return $this->functions;
    }
}
