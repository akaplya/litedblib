<?php

namespace  AKaplya\Orm\Db\Mysql;

use  AKaplya\Orm\Db\ResultInterface;
/**
 * Class Connection
 * @package Db
 */
class Result implements \Iterator, ResultInterface
{
    /**
     * @var \Mysqli_result
     */
    protected $resource;

    /**
     * Iterator position
     *
     * @var int
     */
    protected $position = 0;

    /**
     * @var array
     */
    protected $data;

    /**
     * Constructor
     *
     * @param $resource
     */
    public function __construct(\Mysqli_Result $resource)
    {
        $this->resource = $resource;
    }


    /**
     * Returns current value
     */
    public function current()
    {
        if (!isset($this->data[$this->position])) {
            $this->data[$this->position] = $this->resource->fetch_assoc();
        }
        return $this->data[$this->position];
    }

    /**
     * Move iterator pointer forward
     */
    public function next()
    {
        $this->position++;
    }

    /**
     * Returns key
     *
     * @return int
     */
    public function key()
    {
        return $this->position;
    }

    /**
     * Returns status
     */
    public function valid()
    {
        return (boolean)$this->current();
    }

    /**
     * Rewind iterator
     */
    public function rewind()
    {
        $this->position = 0;
        $this->resource->data_seek(0);
    }

    /**
     * Returns count of selected rows
     *
     * @return int
     */
    public function count()
    {
        $this->resource->num_rows;
    }
}
