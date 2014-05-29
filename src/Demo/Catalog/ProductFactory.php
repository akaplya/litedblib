<?php

namespace  Demo\Catalog;

use Entity\FactoryInterface;

class ProductFactory implements FactoryInterface
{
    protected $metadata = [
        'entity_id' => 'integer',
        'entity_type_id' => 'integer',
        'attribute_set_id' => 'integer',
        'type_id' => 'integer',
        'sku' => 'string',
        'has_options' => 'integer',
        'required_options' => 'integer',
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
        return 'entity_id';
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
        return 'catalog_product_entity';
    }
}

//O:27:"Demo\Catalog\ProductWrapper":8:{s:11:" * entityId";N;s:15:" * entityTypeId";N;s:9:" * typeId";N;s:6:" * sku";N;s:13:" * hasOptions";N;s:18:" * requiredOptions";N;s:10:" * product";O:20:"Demo\Catalog\Product":6:{s:11:" * entityId";N;s:15:" * entityTypeId";N;s:9:" * typeId";N;s:6:" * sku";N;s:13:" * hasOptions";N;s:18:" * requiredOptions";N;}s:10:"hasChanges";b:0;}
