<?php

namespace  Demo\Catalog\Product;

use  Entity\WrapperInterface;
use  Demo\Catalog\Product\Varchar;
use  Entity\ObjectInterface;

class VarcharWrapper implements WrapperInterface
{
    protected $valueId;
    protected $entityTypeId;
    protected $attributeId;
    protected $storeId;
    protected $entityId;
    protected $value;
    protected $varchar;

    /**
     * @param Varchar $varchar
     * @param bool $hasChanges
     */
    public function __construct(
        Varchar $varchar,
        $hasChanges
    ) {
        $this->varchar = $varchar;
        $this->hasChanges = $hasChanges;
    }

    public function setValueId($valueId)
    {
        if ($valueId!== $this->varchar->getValueId()) {
            $this->valueId = $valueId;
            $this->hasChanges = true;
        }
        return $this;
    }

    public function getValueId()
    {
        return (($this->valueId) ?: $this->varchar->getValueId());
    }

    public function setEntityTypeId($entityTypeId)
    {
        if ($entityTypeId!== $this->varchar->getEntityTypeId()) {
            $this->entityTypeId = $entityTypeId;
            $this->hasChanges = true;
        }
        return $this;
    }

    public function getEntityTypeId()
    {
        return (($this->entityTypeId) ?: $this->varchar->getEntityTypeId());
    }

    public function setAttributeId($attributeId)
    {
        if ($attributeId !== $this->varchar->getAttributeId()) {
            $this->attributeId = $attributeId;
            $this->hasChanges = true;
        }
        return $this;
    }

    public function getAttributeId()
    {
        return (($this->attributeId) ?: $this->varchar->getAttributeId());
    }

    public function setStoreId($storeId)
    {
        if ($storeId !== $this->varchar->getStoreId()) {
            $this->storeId = $storeId;
            $this->hasChanges = true;
        }
        return $this;
    }

    public function getStoreId()
    {
        return (($this->storeId) ?: $this->varchar->getStoreId());
    }
//
//    public function setEntity($entity)
//    {
//        $this->entity = $entity;
//    }

    public function setEntityId($entityId)
    {
        if ($entityId !== $this->varchar->getEntityId()) {
            $this->entityId = $entityId;
            $this->hasChanges = true;
        }
        return $this;
    }

    public function getEntityId()
    {
        return (($this->entityId) ?: $this->varchar->getEntityId());
    }

    public function setValue($value)
    {
        if ($value !== $this->varchar->getValue()) {
            $this->value = $value;
            $this->hasChanges = true;
        }
        return $this;
    }

    public function getValue()
    {
        return (($this->value) ?: $this->varchar->getValue());
    }

    public function getIdentity()
    {
        return $this->getValueId();
    }

    public function setIdentity($identity)
    {
        return $this->setValueId($identity);
    }

    public function getIdentifier()
    {
        return $this->getValueId();
    }

    public function setIdentifier($identifier)
    {
        return $this->setValueId($identifier);
    }

    public function toArray()
    {
        return [
            'value_id' => $this->getValueId(),
            'entity_type_id' => $this->getEntityTypeId(),
            'attribute_id' => $this->getAttributeId(),
            'store_id' => $this->getStoreId(),
            'entity_id' => $this->getEntityId(),
            'value' => $this->getValue()
        ];
    }

    public function hasChanges()
    {
        return $this->hasChanges;
    }

    /**
     * flush wrapper data to object
     */
    public function flush()
    {
        if (!empty($this->valueId)) {
            $this->varchar->setValueId($this->valueId);
            $this->valueId = null;
        }
        if (!empty($this->entityTypeId)) {
            $this->varchar->setEntityTypeId($this->entityTypeId);
            $this->entityTypeId = null;
        }
        if (!empty($this->attributeId)) {
            $this->varchar->setAttributeId($this->attributeId);
            $this->attributeId = null;
        }
        if (!empty($this->storeId)) {
            $this->varchar->setStoreId($this->storeId);
            $this->storeId = null;
        }
        if (!empty($this->entityId)) {
            $this->varchar->setEntityId($this->entityId);
            $this->entityId = null;
        }
        if (!empty($this->value)) {
            $this->varchar->setValue($this->value);
            $this->value = null;
        }
        $this->hasChanges = false;
    }

    protected $entity;
    public function setEntity($entity)
    {
        $this->entity = $entity;
    }

    /**
     * Mark entity as new
     */
    public function __wakeup()
    {
        $this->hasChanges = true;
    }
}
