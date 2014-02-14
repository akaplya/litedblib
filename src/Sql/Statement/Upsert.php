<?php

namespace Sql\Statement;

/**
 * Class Insert
 * @package Sql\Statement
 */
class Upsert implements \Sql\Statement
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
     * @var array
     */
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
     * @param $matched
     * @return $this
     */
    public function matched($matched)
    {
        $this->matched = $matched;
        return $this;
    }

    /**
     * Render matched
     *
     * @param $sql
     * @return string
     */
    protected function renderMatched($sql)
    {
        $matched = array();
        foreach($this->matched as $column => $value) {
            $matched[] = $column . " = " . \Sql\Constant::SQL_VALUE . "(" . $value . ")";
        }
        return $sql .= "\n" . \Sql\Constant::SQL_ON_DUPLICATE_KEY_UPDATE . "\n" . implode(",\n", $matched);
    }

    /**
     * Render insert columns
     *
     * @param $sql
     * @return string
     */
    protected function renderColumns($sql)
    {
        return $sql .= " (" . implode(",", array_keys($this->values)) . ")";
    }

    /**
     * Render insert values
     *
     * @param $sql
     * @return string
     */
    protected function renderValues($sql)
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
        return $this->renderMatched(
            $this->renderValues(
            $this->renderColumns(\Sql\Constant::SQL_INSERT . " " . $this->target)
        ));
    }
}
