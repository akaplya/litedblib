<?php

namespace Sql\Statement;

/**
 * Class Insert
 * @package Sql\Statement
 */
class Insert implements \Sql\Statement
{
    /**#@+
     * SQL constants
     */
    const SQL_INSERT = 'INSERT';
    const SQL_VALUES = 'VALUES';

    protected $target;

    protected $columns;

    protected $values;

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
     * Set columns mapping for insert
     *
     * @param array $columns
     * @return $this
     */
    public function columns(array $columns)
    {
        $this->columns = $columns;
        return $this;
    }

    /**
     * Set values to insert
     *
     * @param $values
     * @return $this
     */
    public function values($values)
    {
        $this->values = $values;
        return $this;
    }

    /**
     * Render insert columns
     *
     * @param $sql
     * @return string
     */
    public function renderColumns($sql)
    {
        return $sql .= ' (' . implode(',', $this->columns) . ')';
    }

    /**
     * Render insert values
     *
     * @param $sql
     * @return string
     */
    public function renderValues($sql)
    {
        return $sql .= ' ' .self::SQL_VALUES . '(' . implode(',', $this->values) . ')';
    }

    /**
     * Render sql string
     *
     * @return string
     */
    public function __toString()
    {
        return $this->renderValues(
            $this->renderColumns(self::SQL_INSERT . ' ' . $this->target)
        );
    }
}
