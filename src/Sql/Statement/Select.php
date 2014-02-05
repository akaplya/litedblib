<?php

namespace Sql\Statement;

/**
 * Class Delete
 * @package Sql\Statement
 */
class Select implements \Sql\Statement
{
    const SQL_SELECT        = 'SELECT';
    const SQL_FROM          = 'FROM';
    const SQL_JOIN_INNER    = 'INNER';
    const SQL_JOIN_LEFT     = 'LEFT';
    const SQL_JOIN_RIGHT    = 'RIGHT';
    const SQL_JOIN_CROSS    = 'CROSS';

    protected $from;

    protected $join;

    protected $columns;

    protected $where;

    protected $group;

    protected $having;

    protected $order;

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
     * Add having clause
     *
     * @param \Sql\Clause $having
     * @return $this
     */
    public function having(\Sql\Clause $having)
    {
        $this->having[] = $having;
        return $this;
    }

    /**
     * Add order by clause
     *
     * @param \Sql\Clause $order
     * @return $this
     */
    public function order(\Sql\Clause $order)
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
        $this->from[$alias] = $table;
        return $this;
    }

    /**
     * Add join condition
     *
     * @param $table
     * @param $condition
     * @param string $type
     * @return $this
     */
    public function join($table, $condition, $type = self::SQL_JOIN_INNER)
    {
        if (is_array($table)) {
            $alias  = key($table);
            $table  = end($table);
        } else {
            $alias  = $table;
        }
        $this->join[$alias] = array(
            'table'     => $table,
            'condition' => new \Sql\Clause($condition),
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
            $this->columns[is_string($alias) ? $alias : $column] = $column;
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
            $renderColumns[] = $column
                . (($column == $alias) ? '' : ' AS ' . $alias);
        }
        return $sql .= ' ' . implode(',', $renderColumns);
    }

    /**
     * Render from
     *
     * @param $sql
     * @return string
     */
    protected function renderFrom($sql)
    {
        return $sql .= ' ' . self::SQL_FROM . ' ' . end($this->from) . ' AS ' . key($this->from);
    }

    /**
     * Assemble SQL string
     *
     * @return string
     */
    public function __toString()
    {
        return $this->renderFrom(
            $this->renderColumns(self::SQL_SELECT)
        );
    }
}
