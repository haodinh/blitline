<?php

namespace Haodinh\Blitline\Collection;

use Haodinh\Blitline\Functions\BlitlineFunctions;

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
        if ($function instanceof BlitlineFunctions) {
            parent::add($function);
        }
    }

    /**
     * Add many functions
     *
     * @param array $functions
     * @return FunctionsCollection
     */
    public function addMany(array $functions)
    {
        foreach ($functions as $function) {

            $object = $function instanceof BlitlineFunctions ? $function : new BlitlineFunctions($function);

            $this->add($object);
        }
		
		return FunctionsCollection;
    }
}
