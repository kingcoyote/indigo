<?php

namespace Indigo;

class Model
{
    private $table;
    private $primary_key;
    private $columns;
    private $loaded;
    private $related;
    
    public static function factory($name, $id = false)
    {
        // if no table exists with that name
            // throw model exception

        return new Model($name, $id);
    }

    public function __construct($name, $id = false)
    {
        // set table name
        // set primary key name
    }

    public function __set($name, $value)
    {

    }

    public function __get($name)
    {

    }

    public function save()
    {

    }

    public function load()
    {

    }

    private function insert()
    {

    }

    private function update()
    {

    }

    private function delete()
    {

    }
}

