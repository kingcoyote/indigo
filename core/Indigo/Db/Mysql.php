<?php

namespace Indigo\Db;
use Indigo;

class Mysql implements EngineInterface
{
    private $pdo;
    private $config = [];

    public function __construct(Indigo\Config $config)
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
        } catch(PDOException $e) {
            throw new Exception\Db($e->getMessage(), $e->getCode, $e);
        }
    }

    public function disconnect()
    {

    }
}

