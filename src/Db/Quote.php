<?php

namespace Db;

/**
 * Class Quote
 * @package Db
 */
interface Quote
{
    /**
     * @param $value
     * @return string
     */
    public function quote($value);

    /**
     * @param string $text
     * @param $value
     * @return string
     */
    public function quoteInto($text, $value);

    /**
     * @param string $identifier
     * @return string
     */
    public function quoteIdentifier($identifier);
}
