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
     * Render insert values
     *
     * @param $sql
     * @return string
     */
    protected function renderSet($sql)
    {
        $data = array();
        foreach ($this->values as $column => $value) {
            $data[] = $column . " = " . $value;
        }
        return $sql .= "\n" . \Sql\Constant::SQL_SET . " " . implode(",\n", $data);
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
        return $this->renderWhere(
                $this->renderSet(\Sql\Constant::SQL_UPDATE . " " . $this->target)
            );
    }
}
