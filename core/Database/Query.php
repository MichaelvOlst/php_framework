<?php

namespace Core\Database;

use PDO;

class Query 
{

    protected $connection;

    protected $query;

    protected $args;
 
    public function __construct(Connection $connection, $query, $args = [])
    {
        $this->connection = $connection;
        $this->query = $query;
        $this->args = $args;
    }


    public function get($class = null)
    {   
        return $class === null ? 
                $this->connection->getPdo()->query($this->query)->fetch(PDO::FETCH_OBJ) 
                : $this->connection->getPdo()->query($this->query)->fetchObject($class);
    }


    public function all($class = null)
    {
        return $class === null ? 
                $this->connection->getPdo()->query($this->query)->fetchAll(PDO::FETCH_OBJ) 
                : $this->connection->getPdo()->query($this->query)->fetchAll(PDO::FETCH_CLASS, $class);
    }


}