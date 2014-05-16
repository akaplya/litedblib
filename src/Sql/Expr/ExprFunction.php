<?php

namespace  AKaplya\Orm\Sql\Expr;

use  AKaplya\Orm\Sql\Clause;
use  AKaplya\Orm\Db\Quote;
use  AKaplya\Orm\Sql\Expr;

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
