<?php

namespace Crimson\Mysql;

use Indigo\Db\QueryInterface;
use Indigo\Exception;
use PDO;

class Query implements QueryInterface
{
    const QUERY_SELECT = 'select';
    const QUERY_UPDATE = 'update';
    
    private $pdo;
    private $queryType;
    private $fields = [];
    private $tables = [];
    private $conditionals = [];
    private $limit = [
        'start' => 0,
        'end'   => 2147483647,
    ];
    private $vars = [];

    private $updateTables = [];
    private $updateFields = [];

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }
    
    public function select($field = false)
    {
        $this->queryType = self::QUERY_SELECT;

        if (!$field) {
            // parse $field into a list of fields
        }

        return $this;
    }

    public function update($table)
    {
        $this->queryType = self::QUERY_UPDATE;
        $this->updateTables[] = $table;

        return $this;
    }

    public function set($values)
    {
        foreach ($values as $field => $value) {
            $nonce = sha1($value);

            $this->updateFields[] = "$field = :$nonce";
            $this->vars[$nonce] = $value;
        }

        return $this;
    }

    public function from($table)
    {
        $this->tables[] = $table;

        return $this;
    }

    public function where($field, $operand, $value)
    {
        $nonce = sha1($value);

        switch ($operand)
        {
            case '=':
            case '>':
            case '>=':
            case '<':
            case '<=':
                $this->conditionals[] = "$field $operand :$nonce";
                $this->vars[$nonce] = $value;
                break;
        }

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
        $query = $this->_buildQuery();

        return $this->query($query, $this->vars);
    }

    public function query($query, $args)
    {
        $statement = $this->pdo->prepare($query);
        
        if ($statement->execute($args)) {

            $data = [];
            $row = $statement->fetch(PDO::FETCH_ASSOC);
            while ($row) {
                $data[] = $row;
                $row = $statement->fetch(PDO::FETCH_ASSOC);
            };

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

    private function _buildQuery()
    {
        switch($this->queryType) {
            case self::QUERY_SELECT:
                return $this->_buildQuerySelect();
                break;

            case self::QUERY_UPDATE:
                return $this->_buildQueryUpdate();
                break;
        }
    }

    private function _buildQuerySelect()
    {
        $query = "select";

        if (count($this->fields) > 0) {

        } else {
            $query .= " *";
        }

        $query .= " from";

        foreach ($this->tables as $table) {
            $query .= ' ' . $table;
        }

        $query .= $this->_buildClauseWhere();

        return $query;
    }

    private function _buildQueryUpdate()
    {
        $query = "update ";

        $query .= implode(', ', $this->updateTables);

        $query .= " set ";

        $query .= implode(', ', $this->updateFields);

        $query .= $this->_buildClauseWhere();

        return $query;
    }

    private function _buildClauseWhere()
    {
        $clause = "";

        if (count($this->conditionals) > 0) {
            $clause .= " where";

            foreach ($this->conditionals as $conditional) {
                $clause .= " " . $conditional;
            }
        }

        return $clause;
    }
}

