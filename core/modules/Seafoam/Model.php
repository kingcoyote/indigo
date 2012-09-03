<?php

namespace Seafoam;
use Indigo\Model\ModelInterface;
use Indigo\Db\EngineInterface as DbEngine;

abstract class Model implements ModelInterface
{
    protected $table;
    protected $primary_key = 'id';
    private $columns;
    private $loaded;
    private $related;
    private $db;
    
    public function __construct(Engine $engine, $id = false)
    {
        $this->db =& $engine->db;

        if ($id !== false) {
            $this->load($id);
        }
    }

    public function save()
    {
        // if not valid
            // throw model exception

        // if there is a primary key
            // update
        // else
            // insert
    }

    public function validate()
    {
        // foreach validation rule
            // if not valid
                // add to validation errors

        // if there are validation errors
            // store them
            // return false

        // return true
    }

    private function _update()
    {
        // build sql query
        // execute
        // set saved
    }

    private function _insert()
    {
        // build sql query
        // execute
        // store primary key
        // set saved
        // set loaded
    }

    public function load($id)
    {
        $query = $this->db->createQuery()
            ->select()->from($this->table)->where($this->primary_key, '=', $id);

        $this->columns = $query->execute()[0];
        $this->loaded = true;
    }

    private function delete()
    {
        // build sql query
        // execute
        // unset loaded
        // unset primary key
    }

    private function _init_columns()
    {
        // describe table
        // process columns
    }

    public function reload()
    {
        // clear cached data
        // init columns
        // load
    }

    public function __set($name, $value)
    {
        // if this value does not exist in the columns array
            // throw model exception

        // set value in columns array
        // unset saved
    }

    public function __get($name)
    {
        // if this value exists in the cached data
            // return it
        // else if it is a magic column
            // process data
            // cache it
            // return it
        // else if it is a column
            return $this->columns[$name];
        // else
            // throw model exception
            
    }

    public function __isset($name)
    {
        return array_key_exists($name, $this->columns);
    }

    public function has($object)
    {
        // identify relation between $this and $object
        // call up strategy
        // return strategy->has
    }

    public function add($object)
    {
        // identify relation between $this and $object
        // call up strategy
        // return strategy->add
    }

    public function remove($object)
    {
        // identify relation between $this and $object
        // call up strategy
        // return strategy->remove
    }
}

