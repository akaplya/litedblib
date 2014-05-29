<?php
use Entity\Mapper;
use Entity\Repository;
use Entity\UnitOfWork;
use Entity\Config;
use Sql\Dml;
use Demo\ProductFactory;

require_once "bootstrap.php";
echo "<pre>";


$productFactory = new ProductFactory();
$productMapper = new Mapper(new Dml(), $connection, $productFactory);
$productRepository = new Repository($productMapper);

$uow = new UnitOfWork(
    new Config(), ['products' => $productRepository]
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
