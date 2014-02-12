<?php

namespace Sql\Statement;

/**
 * Class Update
 * @package Sql\Statement
 */
class Update implements \Sql\Statement
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
    protected $where;

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
    public function set(array $values)
    {
        $this->values = $values;
        return $this;
    }

    /**
     * Render insert values
     *
     * @param $sql
     * @return string
     */
    protected function renderSet($sql)
    {
        $data = array();
        foreach ($this->values as $column => $value) {
            $data = $column . " = " . $value;
        }
        return $sql .= ' ' . \Sql\Constant::SQL_SET . " " . implode(",\n", $data);
    }

    /**
     * Render matched
     *
     * @param $sql
     * @return string
     */
    protected function renderWhere($sql)
    {

    }

    /**
     * Render sql string
     *
     * @return string
     */
    public function __toString()
    {
        return $this->renderWhere(
                $this->renderSet(\Sql\Constant::SQL_INSERT . ' ' . $this->target)
            );
    }
}
