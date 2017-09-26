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
     * @var int
     */
    protected $quality = 100;

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
            'quality'          => $this->getQuality(),
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
     * @param string $imageIdentifier
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
        return $this->imageIdentifier;
    }

    /**
     * Set src
     *
     * @param string $src
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
     * Set quality
     *
     * @param int $quality
     * @return BlitlineImage
     */
    public function setQuality(int $quality)
    {
        $this->quality = $quality;

        return $this;
    }

    /**
     * Get quality
     *
     * @return int
     */
    public function getQuality()
    {
        return $this->quality;
    }

    /**
     * Set meta
     *
     * @param MetaImage|array $meta
     * @return BlitlineImage
     */
    public function setMeta($meta)
    {
        $this->meta = $meta instanceof MetaImage ? $meta : new MetaImage($meta);

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
