<?php

namespace  AKaplya\Orm\Sql\Statement\Select;

/**
 * Class Insert
 * @package Sql\Statement
 */
class Insert implements \AKaplya\Orm\Sql\SqlInterface
{
    /**
     * @var string
     */
    protected $target;

    /**
     * @var array
     */
    protected $columns;

    /**
     * @var \AKaplya\Orm\Sql\Statement\Select
     */
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
     * @param \AKaplya\Orm\Sql\Statement $source
     * @return $this
     */
    public function source(\AKaplya\Orm\Sql\Statement $source)
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
        return $sql . ' (' . implode(',', $this->columns) . ')';
    }

    /**
     * Render insert values
     *
     * @param $sql
     * @return string
     */
    public function renderSource($sql)
    {
        return $sql . ' ' . \AKaplya\Orm\Sql\Constant::SQL_VALUES . '(' . (string)$this->source . ')';
    }

    /**
     * Render sql string
     *
     * @return string
     */
    public function __toString()
    {
        return $this->renderValues(
            $this->renderColumns(\AKaplya\Orm\Sql\Constant::SQL_INSERT . ' ' . $this->target)
        );
    }

    /**
     * Render insert values
     *
     * @param $sql
     * @return string
     */
    public function renderValues($sql)
    {
//        return $sql . ' ' . \AKaplya\Orm\Sql\Constant::SQL_VALUES . '(' . implode(',', $this->source) . ')';
    }
}
