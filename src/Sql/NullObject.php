<?php

namespace  AKaplya\Orm\Sql;

/**
 * Class NullObject
 * @package Sql
 */
class NullObject
{
    /**
     * Render sql string
     *
     * @return string
     */
    public function __toString()
    {
        return "NULL";
    }
}
