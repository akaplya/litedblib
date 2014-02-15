<?php

namespace Db\Mysql;

/**
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
        return $value;
    }

    /**
     * @param $identifier
     * @return string
     */
    public function quoteIdentifier($identifier)
    {
        return $identifier;
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
