<?php
use Entity\Object;
use Entity\Mapper;
use Entity\Factory;
use Sql\Dml;

require_once "bootstrap.php";
echo "<pre>";





$productFactory = new \Demo\ProductFactory();
$productMapper = new Mapper(new Dml(), $connection, $productFactory);
$t = 0;
$time = microtime(true);
for ($i = 1; $i <= 100; $i++) {
    $raw = $productFactory->create(['sku' => 'sku#' . rand(1, 10)], false);
    $raw->setName('name#' . rand(1, 10));

    if ($raw->hasChanges()) {
        $t++;
        if ($productMapper->exists($raw->getIdentifier())) {
            $productMapper->update($raw);
        } else {
            $productMapper->create($raw);
        }
    }
}
echo 'Processed ' . ($i - 1) . '(' . $t . ') items for ' . (microtime(true) - $time) . ' sec.';
