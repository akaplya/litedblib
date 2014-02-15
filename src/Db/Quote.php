<?php

namespace Db;

/**
 * Class Quote
 * @package Db
 */
interface Quote
{
    public function quote($value);
    public function quoteInto($text, $value);
    public function quoteIdentifier($identifier);
}
