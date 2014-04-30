<?php

namespace Db\Mysql;

/**
 * Class StatementFactory
 * @package Db\Mysql
 */
class StatementFactory
{
    /**
     * @param \Mysqli_Result $result
     * @return mixed
     */
    public function create(\Mysqli_Stmt $statement)
    {
        return new \Db\Mysql\Statement($statement, new \Db\Mysql\ResultFactory());
    }
}
