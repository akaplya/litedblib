<?php
/**
 * Created by PhpStorm.
 * User: akaplya
 * Date: 2/5/14
 * Time: 12:52 AM
 */

namespace Db\Mysql;

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
        return new \Db\Mysql\Result($result);
    }
}
