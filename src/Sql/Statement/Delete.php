<?php

namespace  Sql\Statement;

use  Sql\SqlInterface;

/**
 * Class Delete
 * @package Sql\Statement
 */
class Delete implements SqlInterface
{
    /**
     * @var string
     */
    protected $target;

    /**
     * @var array
     */
    protected $where;

    /**
     * @var \Db\Quote
     */
    protected $quote;

    /**
     * @param \Db\Quote $quote
     */
    public function __construct(\Db\Quote $quote)
    {
        $this->quote = $quote;
    }

    /**
     * Set target table
     *
     * @param $table
     * @return $this
     */
    public function target($table)
    {
        $this->target = $table;
        return $this;
    }

    /**
     * Add where clause
     *
     * @param \Sql\Clause $where
     * @return $this
     */
    public function where(\Sql\Clause $where)
    {
        $this->where[] = $where;
        return $this;
    }

    /**
     * Render where
     *
     * @param $sql
     * @return mixed
     */
    public function renderWhere($sql)
    {
        $where = new \Sql\Clause\ClauseAnd($this->where);
        $sql .= "\n" . \Sql\Constant::SQL_WHERE . " " . $where;
        return $sql;
    }

    /**
     * Render sql string
     *
     * @return string
     */
    public function __toString()
    {
        if (is_array($this->target)) {
            $target = $this->quote->quoteIdentifier(end($this->target)) . " "
                . \Sql\Constant::SQL_AS . " " . $this->quote->quoteIdentifier(key($this->target));
        } else {
            $target = $this->quote->quoteIdentifier($this->target);
        }
        return $this->renderWhere(
            \Sql\Constant::SQL_DELETE . " "
            . \Sql\Constant::SQL_FROM . " "
            .  $target
        );
    }
}
