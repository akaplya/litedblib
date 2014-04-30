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

    public function create($arguments = [])
    {
        $product = new Product();

        foreach($this->metadata as $field => $type) {
            if (isset($arguments[$field])) {
                $method = 'set' . str_replace(' ', '', ucwords(str_replace('_', ' ', $field)));
                $product->$method($arguments[$field]);
            }
        }
        return $product;
    }

    public function getMetadata()
    {
        return $this->metadata;
    }
}