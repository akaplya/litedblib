<?php

namespace  AKaplya\Orm\Entity;

/**
 * @todo: Split to Entity\FactoryInterface and Entity\MetadataInterface
 *
 * Interface FactoryInterface
 * @package Entity
 */
interface FactoryInterface
{
    const TYPE_STRING = 'string';
    const TYPE_INTEGER = 'integer';
    const TYPE_DECIMAL = 'decimal';
    const TYPE_TIMESTAMP = 'timestamp';


    /**
     * Create wrapped entity
     *
     * @param array $arguments
     * @param bool $hasChanges
     * @return mixed
     */
    public function create($arguments = [], $hasChanges = true);

    /**
     * Return array of metadata
     *
     * @return array
     */
    public function getMetadata();

    /**
     * Returns flag has entity auto_increment data
     *
     * @return bool
     */
    public function hasAutoIncrement();

    /**
     * Returns identity name
     *
     * @return string
     */
    public function getIdentityName();

    /**
     * Returns  identifier name
     *
     * @return string
     */
    public function getIdentifierName();

    /**
     * Returns entity table name
     *
     * @return string
     */
    public function getEntityTableName();

}
