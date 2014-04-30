<?php

namespace Db\Mysql;

use Db\StatementInterface;
use Db\Mysql\ResultFactory;

class Statement implements StatementInterface
{
    protected $statement;
    protected $resultFactory;

    public function __construct(
        \Mysqli_Stmt $statement,
        ResultFactory $resultFactory
    ) {
        $this->statement = $statement;
        $this->resultFactory = $resultFactory;
    }
    public function prepare($params) {
        return array_unshift($params,str_repeat('s', count($params)));
    }

    protected function prepareParams($params)
    {
        $reference = [];
        foreach ($params as $name => $value)
        {
            $reference[$name] = &$params[$name];
        }
        return $reference;
    }

    public function bind($params)
    {
        return call_user_func_array(
            [$this->statement,'bind_param'],
            array_merge(
                [str_repeat('s', count($params))],$this->prepareParams($params))

        );

    }

    public function result()
    {
        $this->execute();
        $result = $this->statement->get_result();
        return $this->resultFactory->create($result);
    }

    public function execute()
    {
        if (!$this->statement->execute()) {
//            echo $this->statement->sqlstate;
            throw new \Exception($this->statement->error, $this->statement->errno);
        }

    }

}