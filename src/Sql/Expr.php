<?php

namespace  AKaplya\Orm\Sql;

/**
 * Class Expression
 * @package Sql
 */
class Expr
{
    /**
     * @var
     */
    protected $expression;

    /**
     * @param $expression
     */
    public function __construct(
        $expression
    ) {
        $this->expression = $expression;
    }

    public function __toString()
    {
        return (string)$this->expression;
    }
}
