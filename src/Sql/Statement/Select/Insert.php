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

    protected $target;

    protected $columns;

    protected $source;

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
     * @param \Sql\Statement $source
     * @return $this
     */
    public function source(\Sql\Statement $source)
    {
        $this->source = $source;
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
    public function renderSource($sql)
    {
        return $sql .= ' ' .self::SQL_VALUES . '(' . (string)$this->source . ')';
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
