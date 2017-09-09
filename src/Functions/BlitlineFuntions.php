<?php

namespace Haodinh\Blitline\Funtions;

use Haodinh\Blitline\Image\BlitlineImage;
use Haodinh\Blitline\Utility\ConvertString;

/**
 * Blitline funtions
 *
 * @author haodinh
 */
class BlitlineFuntions
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var BlitlineImage
     */
    protected $image;

    /**
     * @var array
     */
    protected $params;

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
        return [
            'name'   => $this->getName(),
            'params' => $this->getParams(),
            'save'   => [
                'image_identifier' => $this->getImage()->getImageIdentifier()
            ]
        ];
    }

    /**
     * Config
     *
     * @param array $config
     * @return BlitlineFuntions
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
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return BlitlineFuntions
     */
    public function setName(string $name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get image
     *
     * @return BlitlineImage
     */
    public function getImage()
    {
        if (!$this->image instanceof BlitlineImage) {
            $this->image = new BlitlineImage;
        }

        return $this->image;
    }

    /**
     * Set image
     *
     * @param BlitlineImage $image
     * @return BlitlineFuntions
     */
    public function setImage(BlitlineImage $image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get params
     *
     * @return array
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * Set params
     *
     * @param array $params
     * @return BlitlineFuntions
     */
    public function setParams(array $params)
    {
        $method = ConvertString::toCamelCase($this->getName());

        $this->params = method_exists($this, $method) ? $this->$method(...$params) : $params;

        return $this;
    }

    /**
     * Resize to fit
     *
     * @param int $with
     * @param int $height
     * @param bool $autosharpen
     * @param bool $onlyShrinkLarger
     * @param bool $gravity
     * @return array
     */
    protected function resizeToFit(int $with, int $height, bool $autosharpen = false, bool $onlyShrinkLarger = false, bool $gravity = false)
    {
        return [
            'with'               => $with,
            'height'             => $height,
            'autosharpen'        => $autosharpen,
            'only_shrink_larger' => $onlyShrinkLarger,
            'gravity'            => $gravity
        ];
    }

    /**
     * Resize to fill
     *
     * @param int $with
     * @param int $height
     * @param bool $autosharpen
     * @param bool $onlyShrinkLarger
     * @param bool $gravity
     * @return array
     */
    protected function resizeToFill(int $with, int $height, bool $autosharpen = false, bool $onlyShrinkLarger = false, bool $gravity = false)
    {
        return [
            'with'               => $with,
            'height'             => $height,
            'autosharpen'        => $autosharpen,
            'only_shrink_larger' => $onlyShrinkLarger,
            'gravity'            => $gravity
        ];
    }
}
