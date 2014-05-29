<?php

namespace  Db\Mysql;

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
        return new \Db\Mysql\Statement($statement, new \Db\Mysql\ResultFactory());
    }
}
