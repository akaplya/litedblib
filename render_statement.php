<?php

require_once "bootstrap.php";
echo "<pre>";
/** @var $connection \Db\Mysql\Connection */
$dml = new \Sql\Dml();
$select = $dml->select();
$select->from(array('p' => 'product'))
    ->columns(array('id', 'p.sku', 'upd' => 'p.updated_at', 'amount' => 'i.qty'))
    ->join(array('i' => 'inventory'), new \Sql\Clause('i.product_od = p.id'))
    ->join('test', new \Sql\Clause\ClauseAnd(array('test.test_id = i.test_id', 'test.identifier = 1')),
        \Sql\Constant::SQL_JOIN_LEFT)
    ->where(new \Sql\Clause('i.status = 1'))
    ->where(new \Sql\Clause\ClauseOr(array('p.field1 = 1', 'p.field2 = 2')))
;

echo (string)$select;

$update = $dml->update();
$update->target('test_update_table')
    ->set(array('column_one' => 1, 'column_two' => 'string', 'column_three' => new \Sql\NullObject()))
    ->where(new \Sql\Clause('i.status = 1'));


echo "\n" . (string)$update;

$update = $dml->insert();
$update->target('test_insert_table')
    ->values(array('column_one' => 1, 'column_two' => 'string', 'column_three' => new \Sql\NullObject()));


echo "\n" . (string)$update;