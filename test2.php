<?php
use AKaplya\Orm\Entity\Object;
use AKaplya\Orm\Entity\Mapper;
use AKaplya\Orm\Entity\Factory;
use AKaplya\Orm\Sql\Dml;

require_once "bootstrap.php";
echo "<pre>";

$productFactory = new AKaplya\Orm\Demo\ProductFactory();
$productMapper = new Mapper(new Dml(), $connection, $productFactory);
$t = 0;
$time = microtime(true);
for ($i = 1; $i <= 200000; $i++) {
    $raw = $productFactory->create(['sku' => 'sku#' . rand(1, 100000)], false);
    $raw->setName('name#' . rand(1, 100000));

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
