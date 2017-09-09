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
}
