<?php

namespace Haodinh\Blitline\Image;

/**
 * Blitline image
 *
 * @author haodinh
 */
class BlitlineImage
{
    /**
     * @var string
     */
    protected $imageIdentifier;

    /**
     * @var string
     */
    protected $src;

    /**
     *
     * @var MetaImage
     */
    protected $meta;

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
        $meta = $this->getMeta();

        return [
            'image_identifier' => $this->getImageIdentifier(),
            'src'              => $this->getSrc(),
            'meta'             => $meta()
        ];
    }

    /**
     * Config
     *
     * @param array $config
     * @return BlitlineImage
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
     * Set image identifier
     *
     * @param string
     * @return BlitlineImage
     */
    public function setImageIdentifier(string $imageIdentifier)
    {
        $this->imageIdentifier = $imageIdentifier;

        return $this;
    }

    /**
     * Get image identifier
     *
     * @return string
     */
    public function getImageIdentifier()
    {
        if (!$this->imageIdentifier) {
            $this->imageIdentifier = uniqid();
        }

        return $this->imageIdentifier;
    }

    /**
     * Set src
     *
     * @param string
     * @return BlitlineImage
     */
    public function setSrc(string $src)
    {
        $this->src = $src;

        return $this;
    }

    /**
     * Get src
     *
     * @return string
     */
    public function getSrc()
    {
        return $this->src;
    }

    /**
     * Set meta
     *
     * @param MetaImage
     * @return BlitlineImage
     */
    public function setMeta(MetaImage $meta)
    {
        $this->meta = $meta;

        return $this;
    }

    /**
     * Get meta
     *
     * @return MetaImage
     */
    public function getMeta()
    {
        if (!$this->meta instanceof MetaImage) {
            $this->meta = new MetaImage;
        }

        return $this->meta;
    }
}
