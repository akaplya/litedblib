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

$file = fopen('./tmp/products.data', 'r');
if ($file) {
    while (($buffer = fgets($file, 4096)) !== false) {
        $entity = unserialize($buffer);
        $uow->getRepository('products')->registerEntity($entity);
    }   $t++;
    if (!feof($file)) {
        echo "Error: unexpected exception\n";
    }
    fclose($file);
}
$uow->flush();
echo 'Processed ' . $t . ' items for ' . (microtime(true) - $time) . ' sec.';
