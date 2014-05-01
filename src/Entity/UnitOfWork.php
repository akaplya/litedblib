<?php

namespace Entity;

use Entity\Config;

class UnitOfWork
{
    /**
     * @var Repository[]
     */
    protected $repositories;

    /**
     * @var Config
     */
    protected $config;

    /**
     * @param Config $config
     * @param array $repositories
     */
    public function __construct(Config $config, array $repositories)
    {
        $this->config = $config;
        $this->repositories = $repositories;
    }

    /**
     * @param $code
     * @return Repository
     */
    public function getRepository($code)
    {
        return $this->repositories[$code];
    }

    /**
     *
     */
    public function flush()
    {
        //todo: la-la-la-la implement sorting of possible repositories
        foreach ($this->repositories as $code => $repository) {
            /**@var \Entity\WrapperInterface $entity */
            $changed = 0;
            foreach($repository->toArray() as $entity) {
                if ($entity->hasChanges()) {
                    $changed++;
                    if ($repository->getMapper()->exists($entity->getIdentifier())) {
                        $repository->getMapper()->update($entity);
                    } else {
                        $repository->getMapper()->create($entity);
                    }
                }
            }
            echo $code . " with (" . count($repository->toArray()) . "/" . $changed
                . ") rows has been successfully processed! \n";
        }
    }
}
