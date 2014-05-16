<?php

namespace  AKaplya\Orm\Sql\Expr;

use  AKaplya\Orm\Sql\Clause;
use  AKaplya\Orm\Sql\Constant;
use  AKaplya\Orm\Db\Quote;
use  AKaplya\Orm\Sql\Expr;
/**
 * Class Statement
 * @package Sql
 */
class ExprComparison extends Expr
{
    protected $expression;

    protected $quote;

    public function __construct(
        $expression,
        Quote $quote
    ) {
        $this->quote = $quote;
        $this->expression = $this->quote->quoteIdentifier($expression);
    }

    public function equal($value)
    {
        return new Clause(
            $this->quote->quoteInto($this->expression . " = ?", $value)
        );
    }

    public function notEqual($value)
    {
        return new Clause(
            $this->quote->quoteInto($this->expression . " != ?",  $value)
        );
    }

    public function like($value)
    {
        return new Clause(
            $this->quote->quoteInto(
                $this->expression . " " . Constant::SQL_LIKE . " ?", $value)
        );
    }

    public function notLike($value)
    {
        return new Clause(
            $this->quote->quoteInto(
                $this->expression . " " . Constant::SQL_NOT . " " . Constant::SQL_LIKE . " ?", $value)
        );
    }
}
