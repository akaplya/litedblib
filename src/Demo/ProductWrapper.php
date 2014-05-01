<?php

namespace Demo;

use Demo\Product;
use Entity\ObjectInterface;

class ProductWrapper implements ObjectInterface
{
    /**
     * @var bool
     */
    protected $hasChanges;

    /**
     * @var Product
     */
    protected $product;

    /**
     * @var int
     */
    protected $productId;

    /**
     * @var string
     */
    protected $sku;

    /**
     * @var string
     */
    protected $name;


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

    /**
     * @param $productId
     * @return $this
     */
    public function setProductId($productId)
    {
        if ($productId !== $this->product->getProductId()) {
            $this->product = $productId;
            $this->hasChanges = true;
        }
        return $this;
    }

    /**
     * @return integer
     */
    public function getProductId()
    {
        return (($this->productId) ?: $this->product->getProductId());
    }

    /**
     * @param $sku
     * @return $this
     */
    public function setSku($sku)
    {
        if ($sku !== $this->product->getSku()) {
            $this->sku = $sku;
            $this->hasChanges = true;
        }
        return $this;
    }

    /**
     * @param $name
     * @return $this
     */
    public function setName($name)
    {
        if ($name !== $this->product->getName()) {
            $this->name = $name;
            $this->hasChanges = true;
        }
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSku()
    {
        return (($this->sku) ?: $this->product->getSku());

    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return (($this->name) ?: $this->product->getName());
    }

    /**
     * @return int
     */
    public function getIdentity()
    {
        return $this->getProductId();
    }

    /**
     * @return int|mixed|string
     */
    public function getIdentifier()
    {
        return $this->getSku();
    }

    /**
     * @param int|string $identifier
     * @return $this|ObjectInterface
     */
    public function setIdentifier($identifier)
    {
        return $this->setSku($identifier);
    }

    /**
     * @param $identity
     * @return $this
     */
    public function setIdentity($identity)
    {
        return $this->setProductId($identity);
    }

    /**
     * @return array
     */
    public function toArray()

    {
        return [
            'product_id' => $this->getProductId(),
            'sku' => $this->getSku(),
            'name' => $this->getName()
        ];
    }

    public function hasChanges()
    {
        return $this->hasChanges;
    }
}