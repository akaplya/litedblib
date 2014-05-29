<?php

namespace  Demo\Catalog;


use  Entity\WrapperInterface;
use  Demo\Catalog\Product;

class ProductWrapper implements WrapperInterface
{
    protected $entityId;
    protected $entityTypeId;
    protected $attributeSetId;
    protected $typeId;
    protected $sku;
    protected $hasOptions;
    protected $requiredOptions;
    protected $product;

    /**
     * @param Product $product
     * @param bool $hasChanges
     */
    public function __construct(
        Product $product,
        $hasChanges
    ) {
        $this->product = $product;
        $this->hasChanges = $hasChanges;
    }

    public function setEntityId($entityId)
    {
        if ($entityId !== $this->product->getEntityId()) {
            $this->entityId = $entityId;
            $this->hasChanges = true;
        }
        return $this;
    }

    public function getEntityId()
    {
        return (($this->entityId) ?: $this->product->getEntityId());
    }

    public function setEntityTypeId($entityTypeId)
    {
        if ($entityTypeId !== $this->product->getEntityTypeId()) {
            $this->entityTypeId = $entityTypeId;
            $this->hasChanges = true;
        }
        return $this;
    }

    public function getEntityTypeId()
    {
        return (($this->entityTypeId) ?: $this->product->getEntityTypeId());
    }

    public function setTypeId($typeId)
    {
        if ($typeId !== $this->product->getTypeId()) {
            $this->typeId = $typeId;
            $this->hasChanges = true;
        }
        return $this;
    }

    public function getTypeId()
    {
        return (($this->typeId) ?: $this->product->getTypeId());
    }

    public function setAttributeSetId($attributeSetId)
    {
        if ($attributeSetId !== $this->product->getAttributeSetId()) {
            $this->attributeSetId = $attributeSetId;
            $this->hasChanges = true;
        }
        return $this;
    }

    public function getAttributeSetId()
    {
        return (($this->attributeSetId) ?: $this->product->getAttributeSetId());
    }

    public function setSku($sku)
    {
        if ($sku !== $this->product->getSku()) {
            $this->sku = $sku;
            $this->hasChanges = true;
        }
        return $this;
    }

    public function getSku()
    {
        return (($this->sku) ?: $this->product->getSku());
    }

    public function setHasOptions($hasOptions)
    {
        if ($hasOptions !== $this->product->getHasOptions()) {
            $this->hasOptions = $hasOptions;
            $this->hasChanges = true;
        }
        return $this;
    }

    public function getHasOptions()
    {
        return (($this->hasOptions) ?: $this->product->getHasOptions());
    }

    public function setRequiredOptions($requiredOptions)
    {
        if ($requiredOptions !== $this->product->getRequiredOptions()) {
            $this->requiredOptions = $requiredOptions;
            $this->hasChanges = true;
        }
        return $this;
    }

    public function getRequiredOptions()
    {
        return (($this->requiredOptions) ?: $this->product->getRequiredOptions());
    }

    public function getIdentity()
    {
        return $this->getEntityId();
    }

    public function setIdentity($identity)
    {
        return $this->setEntityId($identity);
    }

    public function getIdentifier()
    {
        return $this->getSku();
    }

    public function setIdentifier($identifier)
    {
        return $this->setSku($identifier);
    }

    public function toArray()
    {
        return [
            'entity_id' => $this->getEntityId(),
            'entity_type_id' => $this->getEntityTypeId(),
            'attribute_set_id' => $this->getAttributeSetId(),
            'type_id' => $this->getTypeId(),
            'sku' => $this->getSku(),
            'has_options' => $this->getHasOptions(),
            'required_options' => $this->getRequiredOptions()
        ];
    }

    /**
     * flush wrapper data to object
     */
    public function flush()
    {
        if (!empty($this->entityId)) {
            $this->product->setEntityId($this->entityId);
            $this->entityId = null;
        }
        if (!empty($this->entityTypeId)) {
            $this->product->setEntityTypeId($this->entityTypeId);
            $this->entityTypeId = null;
        }
        if (!empty($this->attributeSetId)) {
            $this->product->setAttributeSetId($this->attributeSetId);
            $this->attributeSetId = null;
        }
        if (!empty($this->typeId)) {
            $this->product->setTypeId($this->typeId);
            $this->typeId = null;
        }
        if (!empty($this->sku)) {
            $this->product->setSku($this->sku);
            $this->sku = null;
        }
        if (!empty($this->hasOptions)) {
            $this->product->setHasOptions($this->hasOptions);
            $this->hasOptions = null;
        }
        if (!empty($this->requiredOptions)) {
            $this->product->setRequiredOptions($this->requiredOptions);
            $this->requiredOptions = null;
        }
        $this->hasChanges = false;
    }

    public function hasChanges()
    {
        return $this->hasChanges;
    }

    /**
     * Mark entity as new
     */
    public function __wakeup()
    {
        $this->hasChanges = true;
    }
}
