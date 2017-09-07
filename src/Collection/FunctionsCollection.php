<?php

namespace Haodinh\Blitline\Collection;

use Haodinh\Blitline\Functions\BlitlineFuntions;

/**
 * Functions collection
 *
 * @author haodinh
 */
class FunctionsCollection extends ArrayCollection
{

    /**
     * {@inheritdoc}
     */
    public function add($function)
    {
        if ($function instanceof BlitlineFuntions) {
            parent::add($function);
        }
    }

    /**
     * Add many funtions
     * 
     * @param array $functions
     * @return FunctionsCollection
     */
    public function addMany(array $functions)
    {
        foreach ($functions as $function) {

            $object = is_array($function) ? new BlitlineFuntions($function) : $function;

            $this->add($object);
        }
    }
}
