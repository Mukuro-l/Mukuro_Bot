<?php


namespace Hahadu\Collect\Iterators;

use SeekableIterator;

trait Seekable
{
    /**
     * Seeks to a position
     * @param int $offset <p>
     * The position to seek to.
     * </p>
     * @return void
     */
    public function seek($offset)
    {
        $this->getIterator->seek($offset);

    }

}