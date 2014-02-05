<?php

require_once "bootstrap.php";

/** @var $connection \Db\Mysql\Connection */
$select = new \Sql\Statement\Select();

$select->from(array('p' => 'product'))
    ->columns(array('id', 'p.sku', 'upd' => 'p.updated_at'));

$result = $connection->execute((string)$select);

foreach ($result as $row) {
    var_dump($row);
}