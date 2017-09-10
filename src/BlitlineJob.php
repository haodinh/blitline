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
     * @var FunctionsCollection
     */
    protected $functions;

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
        $result['src'] = $this->getOriginImage()->getSrc();

        foreach ($this->getFunctions() as $func) {
            $result['functions'][] = $func();
        }

        return $result;
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
        $this->originImage = $image instanceof BlitlineImage ? $image : new BlitlineImage($image);

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
        $this->functions = $functions instanceof FunctionsCollection ? $functions : new FunctionsCollection($functions);

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
