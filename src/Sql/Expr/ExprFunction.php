<?php

namespace Sql\Expr;

use Sql\Clause;
use Db\Quote;
use Sql\Expr;

/**
 * Class ExprFunction
 * @package Sql
 */
class ExprFunction extends Expr
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
}
