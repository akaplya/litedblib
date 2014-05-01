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
    /**
     * @var \Sql\Dml
     */
    protected $dml;

    /**
     * @var \Db\Connection
     */
    protected $connection;

    /**
     * @var \Entity\FactoryInterface
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
                    ->target($this->entityFactory->getEntityTableName())
                    ->values($params)
            );
        }
        /** @var \Db\StatementInterface $statement */
        $statement = $this->prepared[__FUNCTION__];
        $statement->bind($object->toArray());
        $statement->execute();
        if ($this->entityFactory->hasAutoIncrement()) {
            $object->setIdentity($this->connection->lastInsertId());
        }
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
                    ->from($this->entityFactory->getEntityTableName())
                    ->where($this->dml->exprComparison(
                            $this->entityFactory->getIdentifierName()
                        )->equal($this->dml->expr('?'))));
        }
        /** @var \Db\StatementInterface $statement */
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
        /** @var \Db\StatementInterface $statement */
        $statement = $this->prepared[__FUNCTION__];
        $bind = $object->toArray();

        unset($bind[$this->entityFactory->getIdentityName()]);
        if ($this->entityFactory->getIdentityName() != $this->entityFactory->getIdentifierName()) {
            unset($bind[$this->entityFactory->getIdentifierName()]);
        }
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
                $this->dml->delete()->target($this->entityFactory->getEntityTableName())
                    ->where($this->dml->exprComparison(
                            $this->entityFactory->getIdentifierName()
                        )->equal($this->dml->expr('?')))
            );
        }
        /** @var \Db\StatementInterface $statement */
        $statement = $this->prepared[__FUNCTION__];
        $statement->bind([$object->getIdentifier()]);
        return $statement->execute();
    }
}
