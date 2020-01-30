<?php

namespace Core\Database;

use PDO;

class Prepare 
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
        $stmt = $this->connection->getPdo()->prepare($this->query);
        $stmt->execute($this->args);

        return $class === null ? 
                $stmt->fetch(PDO::FETCH_OBJ) 
                : $stmt->fetchObject($class);
    }


}