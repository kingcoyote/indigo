<?php

namespace Indigo\Module\Mysql;

use Indigo\Db\QueryInterface;
use Indigo\Exception;
use PDO;

class Query implements QueryInterface
{
    private $pdo;
    private $fields = [];
    private $tables = [];
    private $conditionals = [];
    private $limit = [
        'start' => 0,
        'end'   => 2147483647,
    ];
    private $vars = [];

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }
    
    public function select($field)
    {
        $this->fields[] = $field;

        return $this;
    }

    public function from($table)
    {
        $this->tables[] = $table;

        return $this;
    }

    public function where($conditional)
    {
        $this->conditionals[] = $conditionals;

        return $this;
    }

    public function limit($start, $length)
    {
        $this->limit = [
            'start' => $start,
            'length' => $length
        ];

        return $this;
    }

    public function bind($vars)
    {
        $this->vars = $vars;

        return $this;
    }

    public function execute()
    {
        $query = sprintf(
            'select %s from %s',
            implode(',', $this->fields),
            implode(',', $this->tables)
        );

        return $this->query($query, $this->vars);
    }

    public function query($query, $args)
    {
        $statement = $this->pdo->prepare($query);

        if ($statement->execute($this->vars)) {

            $data = [];
            do {
                $row = $statement->fetch(PDO::FETCH_ASSOC);
                $data[] = $row;
            } while ($row);

        } else {
            throw new Exception\Db(
                sprintf(
                    'MySQL query failed: %s. Query: %s',
                    $statement->errorInfo()[2],
                    $query
                )
            );
        }
        
        return $data;
    }
}

