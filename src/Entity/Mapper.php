<?php

namespace Entity;

use Entity\ObjectInterface;
use Sql\Dml;
use Sql\Clause;
use Entity\FactoryInterface;
use Db\Connection;

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

    protected $prepared;

    protected $connection;

    public function __construct(

        Dml $dml,
        Connection $connection,
        $entityIdentifier,
        $entityTable,
        FactoryInterface $entityFactory
    ) {
        $this->dml = $dml;
        $this->connection = $connection;
        $this->entityIdentifier = $entityIdentifier;
        $this->entityTable = $entityTable;
        $this->entityFactory = $entityFactory;
    }

    /**
     * @param ObjectInterface $object
     */
    public function create(ObjectInterface $object)
    {
        if (empty($this->prepared[__FUNCTION__])) {
            $params = [];
            foreach(array_keys($this->entityFactory->getMetadata()) as $column) {
                $params[$column] = '?';
            }
            $this->prepared[__FUNCTION__] = $this->connection->prepare(
                (string)$this->dml
                    ->insert()
                    ->target($this->entityTable)
                    ->values($params)
            );
        }
        /** @var \Db\StatementInterface $statement */
        $statement = $this->prepared[__FUNCTION__];
        $statement->bind($object->toArray());
        $statement->execute();
        $object->setIdentifier($this->connection->lastInsertId());
    }

    /**
     * @param string|int $identifier
     * @return \Entity\ObjectInterface
     */
    public function read($identifier)
    {
        if (empty($this->prepared[__FUNCTION__])) {
            $this->prepared[__FUNCTION__] = $this->connection->prepare(
                $this->dml->select()
                    ->columns(array_keys($this->entityFactory->getMetadata()))
                    ->from($this->entityTable)
                    ->where($this->dml->exprComparison($this->entityIdentifier)->equal($this->dml->expr('?'))));
        }
        /** @var \Db\StatementInterface $statement */
        $statement = $this->prepared[__FUNCTION__];
        $statement->bind([$identifier]);
        return $this->entityFactory->create($statement->result()->current());
    }

    /**
     * @param $identifier
     * @return bool
     */
    public function exists($identifier)
    {
        if (empty($this->prepared[__FUNCTION__])) {
            $this->prepared[__FUNCTION__] = $this->connection->prepare(
                $this->dml->select()
                    ->columns([$this->dml->expr('1')])
                    ->from($this->entityTable)
                    ->where($this->dml->exprComparison($this->entityIdentifier)->equal($this->dml->expr('?'))));
        }
        /** @var \Db\StatementInterface $statement */
        $statement = $this->prepared[__FUNCTION__];
        $statement->bind([$identifier]);
        return (bool)$statement->result()->current();
    }

    /**
     * @param ObjectInterface $object
     */
    public function update(ObjectInterface $object)
    {
        if (empty($this->prepared[__FUNCTION__])) {
            $params = [];
            foreach(array_keys($this->entityFactory->getMetadata()) as $column) {
                $params[$column] = '?';
            }
            unset($params[$this->entityIdentifier]);
            $this->prepared[__FUNCTION__] = $this->connection->prepare(
                $this->dml->update()->target($this->entityTable)
                    ->set($params)
                    ->where($this->dml->exprComparison($this->entityIdentifier)->equal($this->dml->expr('?')))
            );
        }
        /** @var \Db\StatementInterface $statement */
        $statement = $this->prepared[__FUNCTION__];
        $bind = $object->toArray();
        unset($bind[$this->entityIdentifier]);
        $bind[] = $object->getIdentifier();
        $statement->bind($bind);
        return $statement->execute();
    }

    /**
     * @param ObjectInterface $object
     */
    public function delete(ObjectInterface $object)
    {
        if (empty($this->prepared[__FUNCTION__])) {
            $this->prepared[__FUNCTION__] = $this->connection->prepare(
                $this->dml->delete()->target($this->entityTable)
                    ->where($this->dml->exprComparison($this->entityIdentifier)->equal($this->dml->expr('?')))
            );
        }
        /** @var \Db\StatementInterface $statement */
        $statement = $this->prepared[__FUNCTION__];
        $statement->bind([$object->getIdentifier()]);
        return $statement->execute();
    }
}
