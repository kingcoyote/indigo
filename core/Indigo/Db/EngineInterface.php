<?php

namespace Indigo\Db;
use Indigo;

interface EngineInterface
{
    public function __construct(Indigo\Config $config);
    public function connect();
    public function disconnect();
}
