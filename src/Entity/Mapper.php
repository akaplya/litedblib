<?php

namespace Entity;

use Entity\Object;
use Sql\Dml;
use Sql\Clause;
use Entity\Factory;
/**
 * Class Mapper
 * @package Entity
 */
class Mapper
{
    protected $entityTable;

    protected $entityIdentifier;

    protected $entityFactory;

    protected $dml;

    public function __construct(
        Dml $dml,
        $entityIdentifier,
        $entityTable,
        Factory $entityFactory
    ) {
        $this->dml = $dml;
        $this->entityIdentifier = $entityIdentifier;
        $this->entityTable = $entityTable;
        $this->entityFactory = $entityFactory;
    }

    public function create(Object $object)
    {
        return $this->dml->insert()->target($this->entityTable)->values($object->toArray());
    }

    public function read(Object $object)
    {
        return $this->dml->select()
            ->columns(array_keys($object->toArray()))
            ->from($this->entityTable)
            ->where($this->dml->expression($this->entityIdentifier)->equal($object->getIdentifier()));

    }

    public function update(Object $object)
    {
        return $this->dml->update()->target($this->entityTable)
            ->set($object->toArray())
            ->where($this->dml->expression($this->entityIdentifier)->equal($object->getIdentifier()));

    }

    public function delete(Object $object)
    {
        return $this->dml->delete()->target($this->entityTable)
            ->where($this->dml->expression($this->entityIdentifier)->equal($object->getIdentifier()));
    }
}
