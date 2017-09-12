<?php

namespace Haodinh\Blitline;

use Haodinh\Blitline\Utility\ConvertString;

/**
 * Job options
 */
class BlitlineOptions
{
    /**
     * @var string
     */
    protected $postbackUrl;

    /**
     * @var array
     */
    protected $postbackHeaders;

    /**
     * @var bool
     */
    protected $extendedMetadata;

    /**
     * @var bool
     */
    protected $getExif;

    /**
     * @var int
     */
    protected $waitRetryDelay;

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
        $result  = [];
        $methods = get_class_methods(__CLASS__);

        foreach ($methods as $method) {

            $field = preg_replace('/^get/', '', $method);

            if ($field !== $method && $value = $this->$method()) {
                $result[ConvertString::toUnderscore($field)] = $value;
            }
        }

        return $result;
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

            $method = 'set' . ucfirst($key);

            if (is_callable([$this, $method])) {
                $this->$method($value);
            }
        }

        return $this;
    }

    /**
     * Set postback url
     *
     * @param string $postbackUrl
     * @return BlitlineOptions
     */
    public function setPostbackUrl(string $postbackUrl)
    {
        $this->postbackUrl = $postbackUrl;

        return $this;
    }

    /**
     * Get postback url
     *
     * @return string
     */
    public function getPostbackUrl()
    {
        return $this->postbackUrl;
    }

    /**
     * Set postback headers
     *
     * @param array $postbackHeaders
     * @return BlitlineOptions
     */
    public function setPostbackHeaders(array $postbackHeaders)
    {
        $this->postbackHeaders = $postbackHeaders;

        return $this;
    }

    /**
     * Get postback headers
     *
     * @return array
     */
    public function getPostbackHeaders()
    {
        return $this->postbackHeaders;
    }

    /**
     * Set extended metadata
     *
     * @param bool $extendedMetadata
     * @return BlitlineOptions
     */
    public function setExtendedMetadata(bool $extendedMetadata)
    {
        $this->extendedMetadata = $extendedMetadata;

        return $this;
    }

    /**
     * Get extended metadata
     *
     * @return bool
     */
    public function getExtendedMetadata()
    {
        return $this->extendedMetadata;
    }

    /**
     * Set get exif
     *
     * @param bool $getExif
     * @return BlitlineOptions
     */
    public function setGetExif(bool $getExif)
    {
        $this->getExif = $getExif;

        return $this;
    }

    /**
     * Get get exif
     *
     * @return bool
     */
    public function getGetExif()
    {
        return $this->getExif;
    }

    /**
     * Set wait retry delay
     *
     * @param int $waitRetryDelay
     * @return BlitlineOptions
     */
    public function setWaitRetryDelay(int $waitRetryDelay)
    {
        $this->waitRetryDelay = $waitRetryDelay;

        return $this;
    }

    /**
     * Get wait retry delay
     *
     * @return int
     */
    public function getWaitRetryDelay()
    {
        return $this->waitRetryDelay;
    }
}
