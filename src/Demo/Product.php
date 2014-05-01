<?php
namespace Demo;

class Product implements \Entity\ObjectInterface
{
    protected $productId;
    protected $sku;
    protected $name;

    public function setProductId($productId)
    {
        $this->productId = $productId;
        return $this;
    }

    public function getProductId()
    {
        return $this->productId;
    }

    public function setSku($sku)
    {
        $this->sku = $sku;
        return $this;
    }

    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    public function getSku()
    {
        return $this->sku;
    }

    public function getName()
    {
        return $this->name;
    }


    public function getIdentity()
    {
        return $this->getProductId();
    }

    public function setIdentity($identity)
    {
        return $this->setProductId($identity);
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
            'product_id' => $this->getProductId(),
            'sku' => $this->getSku(),
            'name' => $this->getName()
        ];
    }
}