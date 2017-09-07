<?php

namespace Haodinh\Blitline\Collection;

use Iterator;
use Countable;

/**
 * Array collection
 *
 * @author haodinh
 */
class ArrayCollection implements Iterator, Countable
{
    /**
     * @var array
     */
    protected $items;

    /**
     * Constructor
     * 
     * @param array $items
     */
    public function __construct(array $items = [])
    {
        $this->items = $items;
    }

    /**
     * {@inheritdoc}
     */
    public function current()
    {
        return current($this->items);
    }

    /**
     * {@inheritdoc}
     */
    public function key()
    {
        return key($this->items);
    }

    /**
     * {@inheritdoc}
     */
    public function next()
    {
        return next($this->items);
    }

    /**
     * {@inheritdoc}
     */
    public function rewind()
    {
        return reset($this->items);
    }

    /**
     * {@inheritdoc}
     */
    public function valid()
    {
        return !is_null($this->key());
    }

    /**
     * Create item
     * 
     * @param array $items
     */
    public function create(array $items)
    {
        $this->items = $items;

        return $this;
    }

    /**
     * Add item
     * 
     * @param mixed $item
     */
    public function add($item)
    {
        $this->items[] = $item;

        return $this;
    }

    /**
     * Remove item
     * 
     * @param mixed $key
     * @return mixed
     */
    public function remove($key)
    {
        unset($this->items[$key]);

        return $this;
    }

    /**
     * Check is empty
     * 
     * @return ArrayCollection
     */
    public function isEmpty()
    {
        return empty($this->items);
    }

    /**
     * Clear
     * 
     * @return ArrayCollection
     */
    public function clear()
    {
        $this->items = [];

        return $this;
    }

    /**
     * Coutn
     * 
     * @return int
     */
    public function count()
    {
        return count($this->items);
    }

    /**
     * To array
     * 
     * @return array
     */
    public function toArray()
    {
        return $this->items;
    }
}
