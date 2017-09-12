<?php

namespace Haodinh\Blitline\Image;

/**
 * Meta image
 *
 * @author haodinh
 */
class MetaImage
{
    /**
     * @var int
     */
    protected $width;

    /**
     * @var int
     */
    protected $height;

    /**
     * @var int
     */
    protected $filesize;

    /**
     * @var string
     */
    protected $mimeType;

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
        return [
            'width'     => $this->getWidth(),
            'height'    => $this->getHeight(),
            'filesize'  => $this->getFilesize(),
            'mime_type' => $this->getMimeType()
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
     * Set width
     *
     * @param int $width
     * @return MetaImage
     */
    public function setWidth(int $width)
    {
        $this->width = $width;

        return $this;
    }

    /**
     * Get width
     *
     * @return int
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * Set height
     *
     * @param int $height
     * @return MetaImage
     */
    public function setHeight(int $height)
    {
        $this->height = $height;

        return $this;
    }

    /**
     * Get height
     *
     * @return int
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * Set filesize
     *
     * @param int $filesize
     * @return MetaImage
     */
    public function setFilesize(int $filesize)
    {
        $this->filesize = $filesize;

        return $this;
    }

    /**
     * Get filesize
     *
     * @return int
     */
    public function getFilesize()
    {
        return $this->filesize;
    }

    /**
     * Set mime type
     *
     * @param string $mimeType
     * @return MetaImage
     */
    public function setMimeType(string $mimeType)
    {
        $this->mimeType = $mimeType;

        return $this;
    }

    /**
     * Get mime type
     *
     * @return string
     */
    public function getMimeType()
    {
        return $this->mimeType;
    }
}
