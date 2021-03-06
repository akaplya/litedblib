<?php
use AKaplya\Orm\Entity\Mapper;
use AKaplya\Orm\Entity\Repository;
use AKaplya\Orm\Sql\Dml;
use AKaplya\Orm\Demo\ProductFactory;

require_once "bootstrap.php";
echo "<pre>";


$productFactory = new ProductFactory();
$productMapper = new Mapper(new Dml(), $connection, $productFactory);
$productRepository = new Repository($productMapper);

$uow = new AKaplya\Orm\Entity\UnitOfWork(
    new AKaplya\Orm\Entity\Config(), ['products' => $productRepository]
);
$t = 0;
$time = microtime(true);
$file = fopen('./tmp/products.data', 'w');

for ($i = 1; $i <= 100000; $i++) {
$entity = $productRepository->loadEntity('sku#' . $i);
    if ($entity->getIdentity() !== null) {
        fwrite($file, serialize($entity) . "\n");
        $t++;

    }
}
fclose($file);
echo 'Processed ' . ($i - 1) . '(' . $t . ') items for ' . (microtime(true) - $time) . ' sec.';
