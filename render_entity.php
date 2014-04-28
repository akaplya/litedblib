<?php
use Entity\Object;
use Entity\Mapper;
use Entity\Factory;
use Sql\Dml;

require_once "bootstrap.php";
echo "<pre>";

class Product implements Object
{
    protected $productId;
    protected $sku;
    protected $name;

    public function __construct($productId, $sku, $name)
    {
        $this->productId = $productId;
        $this->sku = $sku;
        $this->name = $name;
    }
    public function toArray()

    {
        return [
            'product_id' => $this->getIdentifier(),
            'sku' => $this->sku,
            'name' => $this->name
        ];
    }

    public function getIdentifier()
    {
        return $this->productId;
    }
}
class ProductFactory implements Factory
{
    public function create($args)
    {
        return new Product($args[0], $args[1], $args[2]);
    }
}

$productFactory = new ProductFactory();

$product = $productFactory->create([1, 'sku#1', 'name#1']);

$productMapper = new Mapper(new Dml(), 'product_id', 'products', $productFactory);

echo $productMapper->create($product) . "\n";
echo $productMapper->read($product) . "\n";
echo $productMapper->update($product) . "\n";
echo $productMapper->delete($product) . "\n";