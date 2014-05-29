<?php
use Entity\Mapper;
use Entity\Repository;
use Entity\Config;
use Entity\UnitOfWork;
use Sql\Dml;
use Demo\Catalog\ProductFactory;
use Demo\Catalog\Product\VarcharFactory;
use Demo\Catalog\Product\IntegerFactory;
use Demo\Catalog\Product\DecimalFactory;

require_once "bootstrap.php";

echo "<pre>";

$dml = new Dml();

$productFactory = new ProductFactory();
$varcharFactory = new VarcharFactory();
$integerFactory = new IntegerFactory();
$decimalFactory = new DecimalFactory();
$productMapper = new Mapper($dml, $connection, $productFactory);
$varcharMapper = new Mapper($dml, $connection, $varcharFactory);
$integerMapper = new Mapper($dml, $connection, $varcharFactory);
$decimalMapper = new Mapper($dml, $connection, $varcharFactory);
$productRepository = new Repository($productMapper);
$varcharRepository = new Repository($varcharMapper);
$integerRepository = new Repository($integerMapper);
$decimalRepository = new Repository($decimalMapper);

$uow = new UnitOfWork(new Config(),
    [
        'catalog_product_entity' => $productRepository,
        'catalog_product_entity_varchar' => $varcharRepository,
        'catalog_product_entity_int' => $integerRepository,
        'catalog_product_entity_decimal' => $decimalRepository
    ]
);

$time = microtime(true);
$file = fopen('./tmp/mage-products.data', 'r');
if ($file) {
    while (($buffer = fgets($file, 4096)) !== false) {
        $entity = unserialize(str_replace(PHP_EOL, '', $buffer));
        if ($entity instanceof \Demo\Catalog\ProductWrapper && $entity->getEntityId()) {
            $uow->getRepository('catalog_product_entity')->registerEntity($entity);
        } elseif($entity instanceof \Demo\Catalog\Product\VarcharWrapper && $entity->getValue()) {
            $uow->getRepository('catalog_product_entity_varchar')->registerEntity($entity);
        } elseif($entity instanceof \Demo\Catalog\Product\IntegerWrapper && $entity->getValue()) {
        $uow->getRepository('catalog_product_entity_int')->registerEntity($entity);
        } elseif($entity instanceof \Demo\Catalog\Product\DecimalWrapper && $entity->getValue()) {
            $uow->getRepository('catalog_product_entity_decimal')->registerEntity($entity);
        }
    }
    if (!feof($file)) {
        echo "Error: unexpected exception\n";
    }
    fclose($file);
}

$uow->flush();

echo 'Processed items for ' . (microtime(true) - $time) . ' sec.';
