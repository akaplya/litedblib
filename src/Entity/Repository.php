<?php

namespace  AKaplya\Orm\Entity;

class Repository
{
    protected $entities;

    protected $entityMapper;

    public function __construct(
        Mapper $entityMapper
    )
    {
        $this->entityMapper = $entityMapper;
    }

    /**
     * @param $identifier
     * @return ObjectInterface
     */
    public function loadEntity($identifier)
    {
        if (empty($this->entities[$identifier])) {
            $entity = $this->entityMapper->read($identifier);
            if (!$entity->getIdentifier()) {
                $entity->setIdentifier($identifier);
            }
            $this->entities[$identifier] = $entity;
        }
        return $this->entities[$identifier];
    }

    /**
     * @param ObjectInterface $object
     * @return $this
     * @throws \Exception
     */
    public function registerEntity(ObjectInterface $object)
    {
        if ($object->getIdentifier() === null) {
            throw new \Exception('Cannot register entity without identifier!');
        }
        $this->entities[$object->getIdentifier()] = $object;
        return $this;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return $this->entities;
    }

    /**
     * @return Mapper
     */
    public function getMapper()
    {
        return $this->entityMapper;
    }
}
