<?php

namespace  AKaplya\Orm\Sql\Statement;

/**
 * Class Delete
 * @package Sql\Statement
 */
class Select implements \AKaplya\Orm\Sql\SqlInterface
{
    /**
     * @var array
     */
    protected $from;

    /**
     * @var array
     */
    protected $join = [];

    /**
     * @var array
     */
    protected $columns;

    /**
     * @var array
     */
    protected $where;

    /**
     * @var array
     */
    protected $group;

    /**
     * @var array
     */
    protected $having;

    /**
     * @var array
     */
    protected $order;

    /**
     * @var \AKaplya\Orm\Db\Quote
     */
    protected $quote;

    /**
     * @param \AKaplya\Orm\Db\Quote $quote
     */
    public function __construct(\AKaplya\Orm\Db\Quote $quote)
    {
        $this->quote = $quote;
    }

    /**
     * Add where clause
     *
     * @param \AKaplya\Orm\Sql\Clause $where
     * @return $this
     */
    public function where(\AKaplya\Orm\Sql\Clause $where)
    {
        $this->where[] = $where;
        return $this;
    }

    /**
     * Add having clause
     *
     * @param \AKaplya\Orm\Sql\Clause $having
     * @return $this
     */
    public function having(\AKaplya\Orm\Sql\Clause $having)
    {
        $this->having[] = $having;
        return $this;
    }

    /**
     * Add order by clause
     *
     * @param \AKaplya\Orm\Sql\Clause $order
     * @return $this
     */
    public function order(\AKaplya\Orm\Sql\Clause $order)
    {
        $this->order[] = $order;
        return $this;
    }

    /**
     * Add from table
     *
     * @param $table
     * @return $this
     */
    public function from($table)
    {
        unset($this->from);
        if (is_array($table)) {
            $alias  = key($table);
            $table  = end($table);
        } else {
            $alias  = $table;
        }
        $this->from[$this->quote->quoteIdentifier($alias)] = $this->quote->quoteIdentifier($table);
        return $this;
    }

    /**
     * Add join condition
     *
     * @param $table
     * @param \AKaplya\Orm\Sql\Clause $condition
     * @param string $type
     * @return $this
     */
    public function join($table, \AKaplya\Orm\Sql\Clause $condition, $type = \AKaplya\Orm\Sql\Constant::SQL_JOIN_INNER)
    {
        if (is_array($table)) {
            $alias  = key($table);
            $table  = end($table);
        } else {
            $alias  = $table;
        }
        $this->join[$this->quote->quoteIdentifier($alias)] = array(
            'table'     => $this->quote->quoteIdentifier($table),
            'condition' => $condition,
            'type'      => $type
        );
        return $this;
    }

    /**
     * Add columns
     *
     * @param $columns
     * @return $this
     */
    public function columns($columns)
    {
        foreach($columns as $alias => $column) {
            $this->columns[$this->quote->quoteIdentifier(is_string($alias) ? $alias : $column)] = $column;
        }
        return $this;
    }

    /**
     * Render columns
     *
     * @param $sql
     * @return string
     */
    protected function renderColumns($sql)
    {
        $renderColumns = array();
        foreach ($this->columns as $alias => $column) {
            $renderColumns[] = (string)$column
                . (((string)$column == $alias) ? "" : " " . \AKaplya\Orm\Sql\Constant::SQL_AS . " " . $alias);
        }
        return $sql . "\n" . implode(",", $renderColumns);
    }

    /**
     * Render from
     *
     * @param $sql
     * @return string
     */
    protected function renderFrom($sql)
    {
        return $sql . "\n" . \AKaplya\Orm\Sql\Constant::SQL_FROM . " " . end($this->from)
            . " " . \AKaplya\Orm\Sql\Constant::SQL_AS . " " . key($this->from);
    }

    /**
     * Render joins
     *
     * @param $sql
     * @return mixed
     */
    protected function renderJoin($sql)
    {

        foreach ($this->join as $alias => $join) {
            if (is_array($join['condition'])) {
                $join['condition'] = implode(" " . \AKaplya\Orm\Sql\Constant::SQL_AND . " ", $join['condition']);
            }
            $sql .= "\n" . $join['type'] . " " . $join['table'] . " " . \AKaplya\Orm\Sql\Constant::SQL_AS . " " . $alias . " "
                . \AKaplya\Orm\Sql\Constant::SQL_ON . " " . $join['condition'];
        }
        return $sql;
    }

    /**
     * Render where
     *
     * @param $sql
     * @return mixed
     */
    public function renderWhere($sql)
    {
        $where = new \AKaplya\Orm\Sql\Clause\ClauseAnd($this->where);
        $sql .= "\n" . \AKaplya\Orm\Sql\Constant::SQL_WHERE . " " . $where;
        return $sql;
    }

    /**
     * Assemble SQL string
     *
     * @return string
     */
    public function __toString()
    {
        return $this->renderWhere(
            $this->renderJoin(
            $this->renderFrom(
            $this->renderColumns(\AKaplya\Orm\Sql\Constant::SQL_SELECT)
        )));
    }
}
