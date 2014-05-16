<?php

namespace  AKaplya\Orm\Db\Mysql;

/**
 * Class StatementFactory
 * @package Db\Mysql
 */
class StatementFactory
{
    /**
     * @param \Mysqli_Stmt $statement
     * @return Statement
     */
    public function create(\Mysqli_Stmt $statement)
    {
        return new \AKaplya\Orm\Db\Mysql\Statement($statement, new \AKaplya\Orm\Db\Mysql\ResultFactory());
    }
}
