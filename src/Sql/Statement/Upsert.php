<?php

namespace Sql\Statement;

/**
 * Class Upsert
 * @package Sql\Statement
 */
class Upsert implements \Sql\Statement
{
    /**#@+
     * SQL constants
     */
    const SQL_INSERT = 'INSERT';
    const SQL_VALUES = 'VALUES';
    const SQL_VALUE  = 'VALUE';
    const SQL_ON_DUPLICATE_KEY_UPDATE = 'ON DUPLICATE KEY UPDATE';

    protected $target;

    protected $columns;

    protected $values;

    protected $matched;

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

    public function matched($columns)
    {
        $this->matched = array_merge($this->matched, $columns);
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
     * Render matched
     *
     * @param $sql
     * @return string
     */
    public function renderMatched($sql)
    {
        $matched = array();
        foreach($matched as $column => $value) {
            $matched[] = $column . ' = ' . self::SQL_VALUE . '(' . $value . ')';
        }
        return $sql .= ' ' . self::SQL_ON_DUPLICATE_KEY_UPDATE . '(' . implode(',', $matched) . ')';
    }

    /**
     * Render sql string
     *
     * @return string
     */
    public function __toString()
    {
        return $this->renderMatched(
            $this->renderValues(
            $this->renderColumns(self::SQL_INSERT . ' ' . $this->target)
        ));
    }
}
