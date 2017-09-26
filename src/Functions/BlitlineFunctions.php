<?php

namespace Haodinh\Blitline\Functions;

use Haodinh\Blitline\Image\BlitlineImage;
use Haodinh\Blitline\Collection\FunctionsCollection;
use Haodinh\Blitline\Utility\ConvertString;

/**
 * Blitline functions
 *
 * @author haodinh
 */
class BlitlineFunctions
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
     * @var BlitlineFunctions
     */
    protected $child;

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
        $result = [
            'name'   => $this->getName(),
            'params' => $this->getParams()
        ];

        $image = $this->getImage();

        if ($imageIdentifier = $image->getImageIdentifier()) {
            $result['save'] = [
                'image_identifier' => $imageIdentifier,
                'quality'          => $image->getQuality()
            ];
        }

        foreach ($this->getChild() as $child) {
            $result['functions'][] = $child();
        }

        return $result;
    }

    /**
     * Config
     *
     * @param array $config
     * @return BlitlineFunctions
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
     * @return BlitlineFunctions
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
     * @param BlitlineImage|array $image
     * @return BlitlineFunctions
     */
    public function setImage($image)
    {
        $this->image = $image instanceof BlitlineImage ? $image : new BlitlineImage($image);

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
     * @return BlitlineFunctions
     */
    public function setParams(array $params)
    {
        $method = ConvertString::toCamelCase($this->getName());

        $this->params = method_exists($this, $method) ? $this->$method(...$params) : $params;

        return $this;
    }

    /**
     * Get child
     *
     * @return FunctionsCollection
     */
    public function getChild()
    {
        if (!$this->child instanceof FunctionsCollection) {
            $this->child = new FunctionsCollection;
        }

        return $this->child;
    }

    /**
     * Set child
     *
     * @param FunctionsCollection|array $child
     * @return BlitlineFunctions
     */
    public function setChild($child)
    {
        $this->child = $child instanceof FunctionsCollection ? $child : new FunctionsCollection($child);

        return $this;
    }

    /**
     * Crop
     *
     * @param int $with
     * @param int $height
     * @param int $x
     * @param int $y
     * @param bool $preserveAspectIfSmaller
     * @param bool $gravity
     * @return array
     */
    protected function crop(int $with, int $height, int $x = 0, int $y = 0, bool $preserveAspectIfSmaller = false, bool $gravity = false)
    {
        return [
            'with'                       => $with,
            'height'                     => $height,
            'x'                          => $x,
            'y'                          => $y,
            'preserve_aspect_if_smaller' => $preserveAspectIfSmaller,
            'gravity'                    => $gravity
        ];
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

    /**
     * Scale
     *
     * @param float $scaleFactor
     * @param int $with
     * @param int $height
     * @return array
     */
    protected function scale(float $scaleFactor, int $with = 0, int $height = 0)
    {
        if ($scaleFactor) {
            return [
                'scale_factor' => $scaleFactor
            ];
        } else {
            return [
                'with'   => $with,
                'height' => $height
            ];
        }
    }

    /**
     * Density
     *
     * @param int $dpi
     * @return array
     */
    protected function density(int $dpi)
    {
        return [
            'dpi' => $dpi
        ];
    }
}
