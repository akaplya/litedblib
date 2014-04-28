<?php

namespace Entity;

/**
 * Interface Object
 * @package Entity
 */
interface Object
{
    /**
     * @return int|string
     */
    public function getIdentifier();

    /**
     * @return array
     */
    public function toArray();
}
