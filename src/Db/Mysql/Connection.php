<?php

namespace Db\Mysql;

/**
 * Class Connection
 * @package Db
 */
class Connection implements \Db\Connection
{
    /**
     * @var string
     */
    protected $host;

    /**
     * @var string
     */
    protected $username;

    /**
     * @var string
     */
    protected $password;

    /**
     * @var string
     */
    protected $dbname;

    /**
     * @var string
     */
    protected $port;

    /**
     * @var string
     */
    protected $socket;

    /**
     * @var \Mysqli
     */
    protected $resource;

    /**
     * @var \Db\Mysql\ResultFactory
     */
    protected $resultFactory;

    /**
     * @var StatementFactory
     */
    protected $statementFactory;

    /**
     * Create new connection instance
     */
    protected function connect()
    {
        if (!$this->resource instanceof \Mysqli) {
            $this->resource = new \Mysqli($this->host, $this->username, $this->password, $this->dbname, $this->port, $this->socket);
        }
    }

    /**
     * Constructor
     *
     * @param array $arguments
     * @param ResultFactory $resultFactory
     * @param StatementFactory $statementFactory
     */
    public function __construct(
        array $arguments,
        \Db\Mysql\ResultFactory $resultFactory,
        \Db\Mysql\StatementFactory $statementFactory

    ){
        $this->host = isset($arguments['host']) ? $arguments['host'] : 'localhost';
        $this->username = isset($arguments['username']) ? $arguments['username'] : null;
        $this->password = isset($arguments['password']) ? $arguments['password'] : null;
        $this->dbname = isset($arguments['dbname']) ? $arguments['dbname'] : null;
        $this->port = isset($arguments['port']) ? $arguments['port'] : null;
        $this->socket = isset($arguments['socket']) ? $arguments['socket'] : null;
        $this->resultFactory = $resultFactory;
        $this->statementFactory = $statementFactory;
        $this->connect();
    }

    /**
     * @param $sql
     * @return \Db\StatementInterface
     */
    public function prepare($sql)
    {
        if ($sql instanceOf \Sql\SqlInterface) {
            $sql = (string)$sql;
        }
        return $this->statementFactory->create($this->resource->prepare($sql));
    }

    /**
     * Execute query
     *
     * @param string $sql
     * @return mixed
     * @throws \Exception
     */
    public function query($sql)
    {
        $result = $this->resource->query($sql);
        if(!$result) {
            throw new \Exception('Query failed');
        }
        return $this->resultFactory->create($result);
    }

    /**
     * Returns last insert id
     *
     * @return int|string
     */
    public function lastInsertId()
    {
        return mysqli_insert_id($this->resource);
    }
}
