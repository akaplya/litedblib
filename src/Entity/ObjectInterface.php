<?php

namespace Entity;

/**
 * Interface Object
 * @package Entity
 */
interface ObjectInterface
{
    /**
     * @return int
     */
    public function getIdentity();

    /**
     * @param int $identity
     * @return ObjectInterface
     */
    public function setIdentity($identity);

    /**
     * @return int|string
     */
    public function getIdentifier();

    /**
     * @param int|string $identifier
     * @return ObjectInterface
     */
    public function setIdentifier($identifier);
    /**
     * @return array
     */
    public function toArray();
}
