<?php

namespace Sql;

use Sql\Clause;
use Sql\Clause\ClauseAnd;
use Sql\Constant;
use Db\Quote;
/**
 * @todo: split class to Expression\Function and Expression\Comparison
 * Class Statement
 * @package Sql
 */
class Expression
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
        return new \Sql\Clause(
            $this->quote->quoteInto($this->expression . " = ?", $value)
        );
    }

    public function notEqual($value)
    {
        return new \Sql\Clause(
            $this->quote->quoteInto($this->expression . " != ?",  $value)
        );
    }

    public function like($value)
    {
        return new \Sql\Clause(
            $this->quote->quoteInto(
                $this->expression . " " . Constant::SQL_LIKE . " ?", $value)
        );
    }

    public function notLike($value)
    {
        return new \Sql\Clause(
            $this->quote->quoteInto(
                $this->expression . " " . Constant::SQL_NOT . " " . Constant::SQL_LIKE . " ?", $value)
        );
    }
}
