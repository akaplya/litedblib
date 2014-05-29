<?php

namespace  Demo\Catalog\Product;

use Demo\Catalog\Product\Integer;
use Demo\Catalog\Product\IntegerWrapper;
use Entity\FactoryInterface;

class IntegerFactory implements FactoryInterface
{
    protected $metadata = [
        'value_id' => 'integer',
        'entity_type_id' => 'integer',
        'attribute_id' => 'integer',
        'store_id' => 'integer',
        'entity_id' => 'integer',
        'value' => 'string'
    ];

    /**
     * Create product wrapper
     *
     * @param array $arguments
     * @param bool $hasChanges
     * @return IntegerWrapper
     */
    public function create($arguments = [], $hasChanges = true)
    {
        $product = new Integer();
        foreach($this->metadata as $field => $type) {
            if (isset($arguments[$field])) {
                $method = 'set' . str_replace(' ', '', ucwords(str_replace('_', ' ', $field)));
                $product->$method($arguments[$field]);
            }
        }
        $productWrapper = new IntegerWrapper($product, $hasChanges);
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
        return 'value_id';
    }

    /**
     * Returns identifier name
     *
     * @return string
     */
    public function getIdentifierName()
    {
        return 'value_id';
    }

    /**
     * Get entity table name
     *
     * @return string
     */
    public function getEntityTableName()
    {
        return 'catalog_product_entity_int';
    }
}
