<?php

namespace Core\Database;

use PDO;
use Core\Config\Config;

class Connection 
{
    protected $pdo;

    public function __construct(Config $config)
    {
        try {
            $this->pdo = new PDO($this->getDSN($config), $config->get('db.username'), $config->get('db.password'), $this->getOptions());
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int)$e->getCode());
        }
    }


    protected function getOptions()
    {
        return [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];
    }


    protected function getDSN(Config $config)
    {
        return 'mysql:host='.$config->get('db.host').';dbname='.$config->get('db.database').';charset='.$config->get('db.charset');
    }


    public function query()
    {

    }
}