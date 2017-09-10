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
    public function __construct(array $items = [])
    {
        parent::__construct([]);
        $this->addFunctions($items);
    }

    /**
     * Add functions
     *
     * @param array $functions
     * @return FunctionsCollection
     */
    public function addFunctions(array $functions)
    {
        foreach ($functions as $function) {

            $object = $function instanceof BlitlineFunctions ? $function : new BlitlineFunctions($function);

            $this->add($object);
        }

        return $this;
    }
}
