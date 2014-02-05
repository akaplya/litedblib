<?php

require_once "bootstrap.php";

/** @var $connection \Db\Mysql\Connection */
$result = $connection->execute('select * from product');

foreach ($result as $row) {
    var_dump($row);
}