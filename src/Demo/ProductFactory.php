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

    /**
     * Create product wrapper
     *
     * @param array $arguments
     * @param bool $hasChanges
     * @return ProductWrapper
     */
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

    /**
     * Returns metadata
     *
     * @return array
     */
    public function getMetadata()
    {
        return $this->metadata;
    }

    /**
     * Entity has auto_increment data
     *
     * @return bool
     */
    public function hasAutoIncrement()
    {
        return true;
    }

    /**
     * Returns identity name
     *
     * @return string
     */
    public function getIdentityName()
    {
        return 'product_id';
    }

    /**
     * Returns identifier name
     *
     * @return string
     */
    public function getIdentifierName()
    {
        return 'sku';
    }

    /**
     * Get entity table name
     *
     * @return string
     */
    public function getEntityTableName()
    {
        return 'products';
    }
}
