<?php

namespace  Sql\Clause;

/**
 * Class ClauseAnd
 * @package Sql\Clause
 */
class ClauseAnd extends \Sql\Clause
{
    /**
     * Convert to clause to string
     *
     * @return string
     */
    public function __toString()
    {
        if (!is_array($this->clause)) {
            parent::__toString();
        }
        return "(" . implode(" " . \Sql\Constant::SQL_AND . " ", $this->clause) . ")";
    }
}
