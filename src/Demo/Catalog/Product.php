<?php
namespace  Demo\Catalog;

class Product implements \Entity\ObjectInterface
{
    protected $entityId;
    protected $entityTypeId;
    protected $typeId;
    protected $attributeSetId;
    protected $sku;
    protected $hasOptions;
    protected $requiredOptions;

    public function setEntityId($entityId)
    {
        $this->entityId = $entityId;
        return $this;
    }

    public function getEntityId()
    {
        return $this->entityId;
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

    public function setTypeId($typeId)
    {
        $this->typeId = $typeId;
        return $this;
    }

    public function getTypeId()
    {
        return $this->typeId;
    }

    public function setAttributeSetId($attributeSetId)
    {
        $this->attributeSetId = $attributeSetId;
        return $this;
    }

    public function getAttributeSetId()
    {
        return $this->attributeSetId;
    }

    public function setSku($sku)
    {
        $this->sku = $sku;
        return $this;
    }

    public function getSku()
    {
        return $this->sku;
    }

    public function setHasOptions($hasOption)
    {
        $this->hasOptions = $hasOption;
        return $this;
    }

    public function getHasOptions()
    {
        return $this->hasOptions;
    }

    public function setRequiredOptions($requiredOptions)
    {
        $this->requiredOptions = $requiredOptions;
        return $this;
    }

    public function getRequiredOptions()
    {
        return $this->requiredOptions;
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
}
