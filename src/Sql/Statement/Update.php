<?php

namespace  AKaplya\Orm\Sql\Statement;

/**
 * Class Update
 * @package Sql\Statement
 */
class Update implements \AKaplya\Orm\Sql\SqlInterface
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
     * @var \AKaplya\Orm\Db\Quote
     */
    protected $quote;

    /**
     * @param \AKaplya\Orm\Db\Quote $quote
     */
    public function __construct(\AKaplya\Orm\Db\Quote $quote)
    {
        $this->quote = $quote;
    }

    /**
     * Set target table
     *
     * @param $table
     * @return $this
     */
    public function target($table)
    {
        $this->target = $this->quote->quoteIdentifier($table);
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
     * @param \AKaplya\Orm\Sql\Clause $where
     * @return $this
     */
    public function where(\AKaplya\Orm\Sql\Clause $where)
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
        return $sql . "\n" . \AKaplya\Orm\Sql\Constant::SQL_SET . " " . implode(",\n", $data);
    }

    /**
     * Render where
     *
     * @param $sql
     * @return mixed
     */
    public function renderWhere($sql)
    {
        $where = new \AKaplya\Orm\Sql\Clause\ClauseAnd($this->where);
        return $sql . "\n" . \AKaplya\Orm\Sql\Constant::SQL_WHERE . " " . $where;
    }

    /**
     * Render sql string
     *
     * @return string
     */
    public function __toString()
    {
        return $this->renderWhere(
                $this->renderSet(\AKaplya\Orm\Sql\Constant::SQL_UPDATE . " " . $this->target)
            );
    }
}
