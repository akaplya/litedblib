<?php

namespace  AKaplya\Orm\Entity;


use  AKaplya\Orm\Sql\Dml;
use  AKaplya\Orm\Sql\Clause;

use  AKaplya\Orm\Db\Connection;

/**
 * Class Mapper
 * @package Entity
 */
class Mapper
{
    /**
     * @var \AKaplya\Orm\Sql\Dml
     */
    protected $dml;

    /**
     * @var \AKaplya\Orm\Db\Connection
     */
    protected $connection;

    /**
     * @var \AKaplya\Orm\Entity\FactoryInterface
     */
    protected $entityFactory;

    /**
     * @var array
     */
    protected $prepared;

    /**
     * @param Dml $dml
     * @param Connection $connection
     * @param FactoryInterface $entityFactory
     */
    public function __construct(
        Dml $dml,
        Connection $connection,
        FactoryInterface $entityFactory
    ) {
        $this->dml = $dml;
        $this->connection = $connection;
        $this->entityFactory = $entityFactory;
    }

    /**
     * @param WrapperInterface $object
     */
    public function create(WrapperInterface $object)
    {
        if (empty($this->prepared[__FUNCTION__])) {
            $params = [];
            foreach(array_keys($this->entityFactory->getMetadata()) as $column) {
                $params[$column] = '?';
            }
            $this->prepared[__FUNCTION__] = $this->connection->prepare(
                (string)$this->dml
                    ->insert()
                    ->target($this->entityFactory->getEntityTableName())
                    ->values($params)
            );
        }
        /** @var \AKaplya\Orm\Db\StatementInterface $statement */
        $statement = $this->prepared[__FUNCTION__];
        $statement->bind($object->toArray());
        $statement->execute();
        if ($this->entityFactory->hasAutoIncrement()) {
            $object->setIdentity($this->connection->lastInsertId());
            $object->flush();
        }
    }

    /**
     * @param string|int $identifier
     * @return \AKaplya\Orm\Entity\ObjectInterface
     */
    public function read($identifier)
    {
        if (empty($this->prepared[__FUNCTION__])) {
            $this->prepared[__FUNCTION__] = $this->connection->prepare(
                $this->dml->select()
                    ->columns(array_keys($this->entityFactory->getMetadata()))
                    ->from($this->entityFactory->getEntityTableName())
                    ->where($this->dml->exprComparison(
                            $this->entityFactory->getIdentifierName()
                        )->equal($this->dml->expr('?'))));
        }
        /** @var \AKaplya\Orm\Db\StatementInterface $statement */
        $statement = $this->prepared[__FUNCTION__];
        $statement->bind([$identifier]);
        return $this->entityFactory->create($statement->result()->current(), false);
    }

    /**
     * @param string|int $identifier
     * @return bool
     */
    public function exists($identifier)
    {
        if (empty($this->prepared[__FUNCTION__])) {
            $this->prepared[__FUNCTION__] = $this->connection->prepare(
                $this->dml->select()
                    ->columns([$this->dml->expr('1')])
                    ->from($this->entityFactory->getEntityTableName())
                    ->where($this->dml->exprComparison(
                        $this->entityFactory->getIdentifierName())->equal($this->dml->expr('?'))));
        }
        /** @var \AKaplya\Orm\Db\StatementInterface $statement */
        $statement = $this->prepared[__FUNCTION__];
        $statement->bind([$identifier]);
        return (bool)$statement->result()->current();
    }

    /**
     * @param WrapperInterface $object
     */
    public function update(WrapperInterface $object)
    {
        if (empty($this->prepared[__FUNCTION__])) {
            $params = [];
            foreach(array_keys($this->entityFactory->getMetadata()) as $column) {
                $params[$column] = '?';
            }
            unset($params[$this->entityFactory->getIdentityName()]);
            if ($this->entityFactory->getIdentityName() != $this->entityFactory->getIdentifierName()) {
                unset($params[$this->entityFactory->getIdentifierName()]);
            }

            $this->prepared[__FUNCTION__] = $this->connection->prepare(
                $this->dml->update()->target($this->entityFactory->getEntityTableName())
                    ->set($params)
                    ->where($this->dml->exprComparison(
                        $this->entityFactory->getIdentifierName())->equal($this->dml->expr('?')))
            );
        }
        /** @var \AKaplya\Orm\Db\StatementInterface $statement */
        $statement = $this->prepared[__FUNCTION__];
        $bind = $object->toArray();

        unset($bind[$this->entityFactory->getIdentityName()]);
        if ($this->entityFactory->getIdentityName() != $this->entityFactory->getIdentifierName()) {
            unset($bind[$this->entityFactory->getIdentifierName()]);
        }
        $bind[] = $object->getIdentifier();
        $statement->bind($bind);
        $statement->execute();
        $object->flush();
    }

    /**
     * @param WrapperInterface $object
     */
    public function delete(WrapperInterface $object)
    {
        if (empty($this->prepared[__FUNCTION__])) {
            $this->prepared[__FUNCTION__] = $this->connection->prepare(
                $this->dml->delete()->target($this->entityFactory->getEntityTableName())
                    ->where($this->dml->exprComparison(
                            $this->entityFactory->getIdentifierName()
                        )->equal($this->dml->expr('?')))
            );
        }
        /** @var \AKaplya\Orm\Db\StatementInterface $statement */
        $statement = $this->prepared[__FUNCTION__];
        $statement->bind([$object->getIdentifier()]);
        $object = null;
        return $statement->execute();
    }
}
