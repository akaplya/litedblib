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

$repository = $uow->getRepository('products');
/** @var AKaplya\Orm\Demo\ProductWrapper $product */
$product = $repository->loadEntity(uniqid('####-this-strange-code-####-with-uuid', true));
$product->setName('ololo-strange-name');
var_dump($product);
$uow->flush();
var_dump($product);
$product->setName('same-name-will-not-save-more-then-once');
var_dump($product);
$uow->flush();
var_dump($product);
$product->setName('same-name-will-not-save-more-then-once');
var_dump($product);
$uow->flush();
var_dump($product);
$product->setName('it-is-time-to-change-product-name');
var_dump($product);
$uow->flush();
var_dump($product);