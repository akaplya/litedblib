<?php

namespace Demo;

use Entity\FactoryInterface;

class ProductFactory implements FactoryInterface
{
    protected $metadata = [
        'product_id' => 'integer',
        'sku' => 'string',
        'name' => 'string'
    ];

    public function create($arguments = [], $hasChanges = true)
    {
        $product = new Product();
        foreach($this->metadata as $field => $type) {
            if (isset($arguments[$field])) {
                $method = 'set' . str_replace(' ', '', ucwords(str_replace('_', ' ', $field)));
                $product->$method($arguments[$field]);
            }
        }
        $productWrapper = new ProductWrapper($product, $hasChanges);
        return $productWrapper;
    }

    public function getMetadata()
    {
        return $this->metadata;
    }

    public function hasAutoIncrement()
    {
        return true;
    }

    public function getIdentityName()
    {
        return 'product_id';
    }

    public function getIdentifierName()
    {
        return 'sku';
    }

    public function getEntityTableName()
    {
        return 'products';
    }
}