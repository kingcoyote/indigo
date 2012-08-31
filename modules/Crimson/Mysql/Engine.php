<?php

namespace Crimson\Mysql;

use Indigo\Db\EngineInterface;
use Indigo\Config;
use Indigo\Exception;

class Engine implements EngineInterface
{
    private $pdo;
    private $config = [];
    private $connected = false;

    public function __construct(Config $config)
    {
        $db = $config->get('db');
        
        $this->config['dsn']  = sprintf(
            "mysql:dbname=%s;host=%s",
            $db['name'],
            $db['host']
        );
        $this->config['user'] = $db['user'];
        $this->config['pass'] = $db['pass'];
    }

    public function connect()
    {
        try {
            $this->pdo = new \PDO(
                $this->config['dsn'],
                $this->config['user'],
                $this->config['pass']
            );
            $this->connected = true;
        } catch(PDOException $e) {
            throw new Exception\Db($e->getMessage(), $e->getCode, $e);
        }
    }

    public function disconnect()
    {
        unset($this->pdo);
    }

    public function createQuery()
    {
        if (!$this->connected) {
            throw new Exception\Db('unable to create query - not connected to a database');
        }

        $query = new Query($this->pdo);
        return $query;
    }
}

