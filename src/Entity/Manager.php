<?php

namespace  Entity;

use Sql\Dml;

class Manager
{
    /**
     * @var Dml
     */
    protected $dml;

    protected $reg;


    public function __construct(
        Dml $dml
    )
    {
        $this->dml = $dml;
    }

    public function getRepository($metadataFactory)
    {
    }
} 