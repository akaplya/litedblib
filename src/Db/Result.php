<?php

namespace Db;

/**
 * Interface Result
 * @package Db
 */
interface Result
{
    /**
     * Returns count of selected rows
     *
     * @return int
     */
    public function count();
}