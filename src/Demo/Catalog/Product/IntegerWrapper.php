<?php

namespace  Demo\Catalog\Product;

use Entity\WrapperInterface;
use Demo\Catalog\Product\Integer;
use Entity\ObjectInterface;

class IntegerWrapper implements WrapperInterface
{
    protected $valueId;
    protected $entityTypeId;
    protected $attributeId;
    protected $storeId;
    protected $entityId;
    protected $value;
    protected $integer;

    /**
     * @param Integer $integer
     * @param bool $hasChanges
     */
    public function __construct(
        Integer $integer,
        $hasChanges
    ) {
        $this->integer = $integer;
        $this->hasChanges = $hasChanges;
    }

    public function setValueId($valueId)
    {
        if ($valueId!== $this->integer->getValueId()) {
            $this->valueId = $valueId;
            $this->hasChanges = true;
        }
        return $this;
    }

    public function getValueId()
    {
        return (($this->valueId) ?: $this->integer->getValueId());
    }

    public function setEntityTypeId($entityTypeId)
    {
        if ($entityTypeId!== $this->integer->getEntityTypeId()) {
            $this->entityTypeId = $entityTypeId;
            $this->hasChanges = true;
        }
        return $this;
    }

    public function getEntityTypeId()
    {
        return (($this->entityTypeId) ?: $this->integer->getEntityTypeId());
    }

    public function setAttributeId($attributeId)
    {
        if ($attributeId !== $this->integer->getAttributeId()) {
            $this->attributeId = $attributeId;
            $this->hasChanges = true;
        }
        return $this;
    }

    public function getAttributeId()
    {
        return (($this->attributeId) ?: $this->integer->getAttributeId());
    }

    public function setStoreId($storeId)
    {
        if ($storeId !== $this->integer->getStoreId()) {
            $this->storeId = $storeId;
            $this->hasChanges = true;
        }
        return $this;
    }

    public function getStoreId()
    {
        return (($this->storeId) ?: $this->integer->getStoreId());
    }
//
//    public function setEntity($entity)
//    {
//        $this->entity = $entity;
//    }

    public function setEntityId($entityId)
    {
        if ($entityId !== $this->integer->getEntityId()) {
            $this->entityId = $entityId;
            $this->hasChanges = true;
        }
        return $this;
    }

    public function getEntityId()
    {
        return (($this->entityId) ?: $this->integer->getEntityId());
    }

    public function setValue($value)
    {
        if ($value !== $this->integer->getValue()) {
            $this->value = $value;
            $this->hasChanges = true;
        }
        return $this;
    }

    public function getValue()
    {
        return (($this->value) ?: $this->integer->getValue());
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
            $this->integer->setValueId($this->valueId);
            $this->valueId = null;
        }
        if (!empty($this->entityTypeId)) {
            $this->integer->setEntityTypeId($this->entityTypeId);
            $this->entityTypeId = null;
        }
        if (!empty($this->attributeId)) {
            $this->integer->setAttributeId($this->attributeId);
            $this->attributeId = null;
        }
        if (!empty($this->storeId)) {
            $this->integer->setStoreId($this->storeId);
            $this->storeId = null;
        }
        if (!empty($this->entityId)) {
            $this->integer->setEntityId($this->entityId);
            $this->entityId = null;
        }
        if (!empty($this->value)) {
            $this->integer->setValue($this->value);
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
