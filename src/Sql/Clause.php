<?php

namespace Sql;

/**
 * Class Clause
 * @package Sql
 */
class Clause
{
    protected $clause;

    public function __construct($clause)
    {
        $this->clause = $clause;
    }

    public function __toString()
    {
        return $this->clause;
    }
}
