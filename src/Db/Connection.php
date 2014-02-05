<?php

namespace Db;

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
    public function execute($sql);
}
