<?php

namespace Sql\Clause;

/**
 * Class ClauseOr
 * @package Sql\Clause
 */
class ClauseOr extends \Sql\Clause
{
    protected $clause;

    public function __construct($clause)
    {
        $this->clause = $clause;
    }

    public function __toString()
    {
        if (!is_array($this->clause)) {
            parent::__toString();
        }
        return "(" . implode(" " . \Sql\Constant::SQL_OR . " ", $this->clause) . ")";
    }
}
