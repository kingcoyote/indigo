<?php

namespace Seafoam;
use Indigo\Model\EngineInterface;
use Indigo\Config;
use Indigo\Db;

class Engine implements EngineInterface
{
    public function __construct(Config $config)
    {
        $this->db = Db::factory();
    }

    public function fetch($name, $id=false)
    {
        if (class_exists($name)) {
            $model = new $name($this, $id);
            return $model;
        }
    }

    public function fetch_models($name, $keys)
    {

    }

}

