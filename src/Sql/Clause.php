<?php

namespace  AKaplya\Orm\Sql;

/**
 * Class Clause
 * @package Sql
 */
class Clause
{
    /**
     * @var string
     */
    protected $clause;

    /**
     * @param string $clause
     */
    public function __construct($clause)
    {
        $this->clause = $clause;
    }

    /**
     * Convert clause to string
     *
     * @return string
     */
    public function __toString()
    {
        return $this->clause;
    }
}
