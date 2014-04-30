<?php

namespace Db\Mysql;

use Sql\Expr;

/**
 * @todo: add normal quoting
 *
 * Class Quote
 * @package Db\Mysql
 */
class Quote implements \Db\Quote
{
    /**
     * @param $value
     * @return string
     */
    public function quote($value)
    {
        if ($value instanceof Expr) {
            return (string)$value;
        }
        return "'" . $value . "'";
    }

    /**
     * @param $identifier
     * @return string
     */
    public function quoteIdentifier($identifier)
    {
        if ($identifier instanceof Expr) {
            return (string)$identifier;
        }
        return "`" . $identifier . "`";
    }

    /**
     * @param $text
     * @param $value
     * @return string
     */
    public function quoteInto($text, $value)
    {
        return str_replace('?', $this->quote($value), $text);
    }
}
