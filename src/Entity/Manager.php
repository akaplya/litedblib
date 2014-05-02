<?php

namespace Entity;

use Entity\UnitOfWork;

class Manager
{
    /**
     * @var UnitOfWork
     */
    protected $unitOfWork;

    public function __construct(
        UnitOfWork $unitOfWork
    )
    {
        $this->unitOfWork = $unitOfWork;
    }

    public function getRepository($entity)
    {

    }
} 