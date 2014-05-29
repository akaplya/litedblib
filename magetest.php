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
ini_set('memory_limit','4096M');
$time = microtime(true);

$dml = new Dml();

$productFactory = new ProductFactory();
$varcharFactory = new VarcharFactory();
$integerFactory = new IntegerFactory();
$decimalFactory = new DecimalFactory();
$productMapper = new Mapper($dml, $connection, $productFactory);
$varcharMapper = new Mapper($dml, $connection, $varcharFactory);
$integerMapper = new Mapper($dml, $connection, $integerFactory);
$decimalMapper = new Mapper($dml, $connection, $decimalFactory);
$productRepository = new Repository($productMapper);
$varcharRepository = new Repository($varcharMapper);
$integerRepository = new Repository($integerMapper);
$decimalRepository = new Repository($decimalMapper);

$uow = new UnitOfWork(new Config(),
    [
        'catalog_product_entity' => $productRepository,
        'catalog_product_entity_varchar' => $varcharRepository,
        'catalog_product_entity_int' => $varcharRepository,
        'catalog_product_entity_decimal' => $varcharRepository
    ]
);

$products = $dml->select()
    ->from(['cpe' => 'catalog_product_entity'])
    ->columns(['sku'])
    ->where($dml->clause('sku IS NOT NULL'));
$file = './tmp/mage-products.data';
//$file = fopen('./tmp/mage-products.data', 'w');
$productsIds = $connection->query($products  . ' limit 1000');
$i = 0;
$t = 0;
$file = fopen('./tmp/mage-products.data', 'w');
foreach ($productsIds as $row) {
    $i++;
    $entity = $productRepository->loadEntity($row['sku']);
    fwrite($file, serialize($entity) . PHP_EOL);
    $varchars = $dml->select()
        ->from(['cpv' => 'catalog_product_entity_varchar'])
        ->columns(['value_id'])
        ->where(
            $dml->clauseAnd([
                $dml->exprComparison('cpv.entity_id')->equal($entity->getIdentity()),
                $dml->exprComparison('cpv.store_id')->equal(0)
            ])
        );
    $ingeters = $dml->select()
        ->from(['cpv' => 'catalog_product_entity_int'])
        ->columns(['value_id'])
        ->where(
            $dml->clauseAnd([
                $dml->exprComparison('cpv.entity_id')->equal($entity->getIdentity()),
                $dml->exprComparison('cpv.store_id')->equal(0)
            ])
        );


    $decimals = $dml->select()
        ->from(['cpv' => 'catalog_product_entity_decimal'])
        ->columns(['value_id'])
        ->where(
            $dml->clauseAnd([
                $dml->exprComparison('cpv.entity_id')->equal($entity->getIdentity()),
                $dml->exprComparison('cpv.store_id')->equal(0)
            ])
        );

    $varcharsIds = $connection->query($varchars);
    foreach ($varcharsIds as $srow) {
        $t++;
        $entityv = $varcharRepository->loadEntity($srow['value_id']);
        fwrite($file, serialize($entityv) . PHP_EOL);
    }
    $integertsIds = $connection->query($ingeters);
    foreach ($integertsIds as $srow) {
        $t++;
        $entityv = $integerRepository->loadEntity($srow['value_id']);
        fwrite($file, serialize($entityv) . PHP_EOL);
    }
    $decimalsIds = $connection->query($decimals);
    foreach ($decimalsIds as $srow) {
        $t++;
        $entityv = $decimalRepository->loadEntity($srow['value_id']);
        fwrite($file, serialize($entityv) . PHP_EOL);
    }
}
fclose($file);
echo 'Processed ' . ($i - 1) . '(' . $t . ') items for ' . (microtime(true) - $time) . ' sec.';
