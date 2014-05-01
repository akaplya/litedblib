<?php

namespace Sql\Clause;

/**
 * Class ClauseOr
 * @package Sql\Clause
 */
class ClauseOr extends \Sql\Clause
{

    /**
     * Convert clause to string
     *
     * @return string
     */
    public function __toString()
    {
        if (!is_array($this->clause)) {
            parent::__toString();
        }
        return "(" . implode(" " . \Sql\Constant::SQL_OR . " ", $this->clause) . ")";
    }
}
