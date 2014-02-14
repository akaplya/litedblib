<?php

namespace Sql\Statement;

/**
 * Class Delete
 * @package Sql\Statement
 */
class Delete implements \Sql\Statement
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
        return $this->renderWhere(\Sql\Constant::SQL_DELETE . " " . $this->target);
    }
}
