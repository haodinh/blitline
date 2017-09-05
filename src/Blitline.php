<?php

namespace Haodinh;

/**
 * Blitline
 */
class Blitline
{
    /**
     * @var string
     */
    const VERSION = '1.21';

    /**
     * @var string
     */
    protected $applicationId;

    /**
     * Constructor
     * 
     * @param string $applicationId
     */
    public function __construct(string $applicationId)
    {
        $this->applicationId = $applicationId;
    }
}
