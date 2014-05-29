<?php
namespace  Demo\Catalog\Product;

class Integer implements \Entity\ObjectInterface
{
    protected $valueId;
    protected $entityTypeId;
    protected $attributeId;
    protected $storeId;
    protected $entityId;
    protected $value;

    public function setValueId($valueId)
    {
        $this->valueId = $valueId;
        return $this;
    }

    public function getValueId()
    {
        return $this->valueId;
    }

    public function setEntityTypeId($entityTypeId)
    {
        $this->entityTypeId = $entityTypeId;
        return $this;
    }

    public function getEntityTypeId()
    {
        return $this->entityTypeId;
    }

    public function setAttributeId($attributeId)
    {
        $this->attributeId = $attributeId;
        return $this;
    }

    public function getAttributeId()
    {
        return $this->attributeId;
    }

    public function setStoreId($storeId)
    {
        $this->storeId = $storeId;
        return $this;
    }

    public function getStoreId()
    {
        return $this->storeId;
    }

    public function setEntityId($entityId)
    {
        $this->entityId = $entityId;
        return $this;
    }

    public function getEntityId()
    {
        return $this->entityId;
    }

    public function setValue($value)
    {
        $this->value = $value;
        return $this;
    }

    public function getValue()
    {
        return $this->value;
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
}
