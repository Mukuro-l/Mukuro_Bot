<?php


namespace Hahadu\Collect\Iterators;
use ArrayIterator;

trait Iteratorable
{
    protected $getIterator;
    //IteratorAggregate
    public function getIterator($flags=0)
    {
        return $this->getIterator = new ArrayIterator($this->items,$flags);
        //return $this->getIterator;
    }

    /**
     * Return the current element
     * @return mixed Can return any type.
     */
    public function current()
    {
        return $this->getIterator->current();

    }

    /**
     * Move forward to next element
     * @return void Any returned value is ignored.
     */
    public function next()
    {
        $this->getIterator->next();
    }

    /**
     * Return the key of the current element
     * @return string|float|int|bool|null scalar on success, or null on failure.
     */
    public function key()
    {
        return $this->getIterator->key();
    }

    /**
     * Checks if current position is valid
     * @return bool The return value will be casted to boolean and then evaluated.
     * Returns true on success or false on failure.
     */
    public function valid()
    {
        return $this->getIterator->valid();
    }

    /**
     * Rewind the Iterator to the first element
     * @return void Any returned value is ignored.
     */
    public function rewind()
    {
        $this->getIterator->rewind();

    }


}