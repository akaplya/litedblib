<?php

namespace  AKaplya\Orm\Db;

/**
 * Interface Result
 * @package Db
 */
interface StatementInterface
{
    public function bind($params);

    /**
     * @return \AKaplya\Orm\Db\ResultInterface
     */
    public function result();

    /**
     * Execute statement
     */
    public function execute();

}