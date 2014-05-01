<?php

namespace Entity;

/**
 * @todo: Split to Entity\FactoryInterface and Entity\MetadataInterface
 *
 * Interface FactoryInterface
 */
interface FactoryInterface
{
    const TYPE_STRING = 'string';
    const TYPE_INTEGER = 'integer';
    const TYPE_DECIMAL = 'decimal';
    const TYPE_TIMESTAMP = 'timestamp';

    public function create($arguments = []);

    public function getMetadata();

    public function hasAutoIncrement();

    public function getIdentityName();

    public function getIdentifierName();

    public function getEntityTableName();

}
