<?php

namespace Haodinh\Blitline\Utility;

/**
 * Convert string
 *
 * @author haodinh
 */
class ConvertString
{

    /**
     * Convert string to underscore
     * 
     * @param string $str
     * @return string 
     */
    public static function toUnderscore(string $str)
    {
        return strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $str));
    }

    /**
     * Convert string to camel case
     * 
     * @param string $str
     * @param string|array $delimiter
     * @return string
     */
    public static function toCamelCase(string $str, $delimiter = '_')
    {
        return str_replace(' ', '', ucwords(str_replace($delimiter, ' ', $str)));
    }
}
