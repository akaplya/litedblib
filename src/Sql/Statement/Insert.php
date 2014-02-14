<?php

namespace Sql\Statement;

/**
 * Class Insert
 * @package Sql\Statement
 */
class Insert implements \Sql\Statement
{
    /**
     * @var string
     */
    protected $target;

    /**
     * @var array
     */
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
        return $sql .= " (" . implode(",", array_keys($this->values)) . ")";
    }

    /**
     * Render insert values
     *
     * @param $sql
     * @return string
     */
    public function renderValues($sql)
    {
        return $sql .= "\n" . \Sql\Constant::SQL_VALUES . " (" . implode(",", $this->values) . ")";
    }

    /**
     * Render sql string
     *
     * @return string
     */
    public function __toString()
    {
        return $this->renderValues(
            $this->renderColumns(\Sql\Constant::SQL_INSERT . ' ' . $this->target)
        );
    }
}
