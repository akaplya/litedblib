<?php
use Entity\Mapper;
use Entity\Repository;
use Sql\Dml;
use Demo\ProductFactory;

require_once "bootstrap.php";
echo "<pre>";


$productFactory = new ProductFactory();
$productMapper = new Mapper(new Dml(), $connection, $productFactory);
$productRepository = new Repository($productMapper);

$entity = $productRepository->loadEntity('not-existing-entity');

var_dump($entity);

//
//$time = microtime(true);
//for ($i = 1; $i <= 100000; $i++) {
//    $raw = $productFactory->create(['sku' => 'sku#' . rand(1, 500)], false);
//    $raw->setName('name#' . rand(1, 500));
//
//    if ($raw->hasChanges()) {
//        if ($productMapper->exists($raw->getIdentifier())) {
//            $productMapper->update($raw);
//        } else {
//            $productMapper->create($raw);
//        }
//    }
////    $productMapper->create($init);
////    $product = $productMapper->read($init->getIdentity());
//}
//
//echo 'Processed ' . ($i - 1) . ' items for ' . (microtime(true) - $time) . ' sec.';
