<?php

namespace  AKaplya\Orm\Sql\Clause;

/**
 * Class ClauseOr
 * @package Sql\Clause
 */
class ClauseOr extends \AKaplya\Orm\Sql\Clause
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
        return "(" . implode(" " . \AKaplya\Orm\Sql\Constant::SQL_OR . " ", $this->clause) . ")";
    }
}
