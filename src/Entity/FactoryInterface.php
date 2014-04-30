<?php

namespace Entity;

/**
 * Interface Factory
 */
interface FactoryInterface
{
    const TYPE_STRING = 'string';
    const TYPE_INTEGER = 'integer';
    const TYPE_DECIMAL = 'decimal';
    const TYPE_TIMESTAMP = 'timestamp';

    public function create($arguments = []);

    public function getMetadata();
}
