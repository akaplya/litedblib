<?php

namespace  Entity;

/**
 * Class WrapperInterface
 * @package Entity
 */
interface WrapperInterface extends ObjectInterface
{
    /**
     * @return bool
     */
    public function hasChanges();

    /**
     * Flush changes to object
     */
    public function flush();
}
