<?php

namespace  Db;

/**
 * Interface Connection
 * @package Db
 */
interface Connection
{
    /**
     * Execute query
     *
     * @param string $sql
     * @return mixed
     * @throws \Exception
     */
    public function query($sql);

    /**
     * @param $sql
     * @return \Db\StatementInterface
     */
    public function prepare($sql);

    /**
     * @return int
     */
    public function lastInsertId();
}
