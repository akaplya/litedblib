<?php

namespace  AKaplya\Orm\Db;

/**
 * Interface Result
 * @package Db
 */
interface ResultInterface extends \Iterator
{
    /**
     * Returns count of selected rows
     *
     * @return int
     */
    public function count();
}