<?php

namespace Db;

/**
 * Interface Result
 * @package Db
 */
interface StatementInterface
{
    public function bind($params);

    /**
     * @return \Db\ResultInterface
     */
    public function result();

    public function execute();

}