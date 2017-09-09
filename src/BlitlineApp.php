<?php

namespace Haodinh\Blitline;

/**
 * Blitline app
 */
class BlitlineApp
{
    /**
     * @var string
     */
    protected $version = '1.21';

    /**
     * @var string
     */
    protected $applicationId;

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
            'application_id' => $this->getApplicationId(),
            'v'              => $this->getVersion()
        ];
    }

    /**
     * Config
     *
     * @param array $config
     * @return BlitlineApp
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
     * Set version
     *
     * @param string $version
     * @return BlitlineApp
     */
    public function setVersion(string $version)
    {
        $this->version = $version;

        return $this;
    }

    /**
     * Get version
     *
     * @return string
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * Set application id
     *
     * @param string $applicationId
     * @return BlitlineApp
     */
    public function setApplicationId(string $applicationId)
    {
        $this->applicationId = $applicationId;

        return $this;
    }

    /**
     * Get application id
     *
     * @return string
     */
    public function getApplicationId()
    {
        return $this->applicationId;
    }
}
