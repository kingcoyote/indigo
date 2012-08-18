<?php

namespace Indigo\Db;

interface QueryInterface
{
    public function select($field);
    public function from($table);
    public function where($conditional);
    public function limit($start, $length);
    public function bind($vars);
    public function execute();
}

