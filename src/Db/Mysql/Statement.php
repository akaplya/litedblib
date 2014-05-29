<?php

namespace  Db\Mysql;

use  Db\StatementInterface;

/**
 * Class Statement
 * @package Db\Mysql
 */
class Statement implements StatementInterface
{
    /**
     * @var \Mysqli_Stmt
     */
    protected $statement;

    /**
     * @var ResultFactory
     */
    protected $resultFactory;

    /**
     * @param \Mysqli_Stmt $statement
     * @param ResultFactory $resultFactory
     */
    public function __construct(
        \Mysqli_Stmt $statement,
        ResultFactory $resultFactory
    ) {
        $this->statement = $statement;
        $this->resultFactory = $resultFactory;
    }

    /**
     * Prepare params
     *
     * @param $params
     * @return array
     */
    protected function prepareParams($params)
    {
        $reference = [];
        foreach ($params as $name => $value)
        {
            $reference[$name] = &$params[$name];
        }
        return $reference;
    }

    /**
     * Bind params
     *
     * @param $params
     * @return mixed
     */
    public function bind($params)
    {
        return call_user_func_array(
            [$this->statement,'bind_param'],
            array_merge(
                [str_repeat('s', count($params))],$this->prepareParams($params))

        );

    }

    /**
     * Returns result
     *
     * @return \Db\ResultInterface
     */
    public function result()
    {
        $this->execute();
        $result = $this->statement->get_result();
        return $this->resultFactory->create($result);
    }

    /**
     * Execute sql statement
     * @throws \Exception
     */
    public function execute()
    {
        if (!$this->statement->execute()) {
//            echo $this->statement->sqlstate;
            throw new \Exception($this->statement->error, $this->statement->errno);
        }

    }

}