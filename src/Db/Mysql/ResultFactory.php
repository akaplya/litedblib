<?php

namespace  AKaplya\Orm\Db\Mysql;

/**
 * Class ResultFactory
 * @package Db\Mysql
 */
class ResultFactory
{
    /**
     * @param \Mysqli_Result $result
     * @return mixed
     */
    public function create(\Mysqli_Result $result)
    {
        return new \AKaplya\Orm\Db\Mysql\Result($result);
    }
}
