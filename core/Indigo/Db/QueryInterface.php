<?php

namespace Indigo\Db;

interface QueryInterface
{
    public function select($field);
    public function from($table);
    public function where($field, $operand, $value);
    public function limit($start, $length);
    public function bind($vars);
    public function execute();

    public function update($table);
    public function set($values);

    public function query($query, $args);
}

