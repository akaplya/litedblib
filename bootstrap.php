<?php

require_once "vendor/autoload.php";

$conn = array(
    'host'     => 'localhost',
    'username' => 'root',
    'dbname'   => 'test',
    'password' => '123123q',
    'port'     => '3306'
);
$connection = new \Db\Mysql\Connection($conn, new \Db\Mysql\ResultFactory(), new \Db\Mysql\StatementFactory());
