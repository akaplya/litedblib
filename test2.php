<?php
use Entity\Object;
use Entity\Mapper;
use Entity\Factory;
use Sql\Dml;

require_once "bootstrap.php";
echo "<pre>";





$productFactory = new \Demo\ProductFactory();
$productMapper = new Mapper(new Dml(), $connection,  'product_id', 'products', $productFactory);

$time = microtime(true);
for ($i = 1; $i <= 100000; $i++) {
    $raw = $productFactory->create(['product_id' => rand(1, 50000), 'sku' => 'sku#' . uniqid(true), 'name' => 'name#' . uniqid(true)]);
    if ($productMapper->exists($raw->getIdentifier())) {
        $productMapper->update($raw);
    } else {
        $productMapper->create($raw);
    }
//    $productMapper->create($init);
//    $product = $productMapper->read($init->getIdentifier());
}

echo 'Processed ' . ($i - 1) . ' items for ' . (microtime(true) - $time) . ' sec.';
