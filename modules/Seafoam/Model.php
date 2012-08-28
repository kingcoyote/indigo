<?php

namespace Seafoam;

abstract class Model
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

    public function load()
    {
        // build sql query
        // execute
        // store data
        // set loaded
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
            // return it
        // else
            // throw model exception
            
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

