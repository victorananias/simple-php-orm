<?php

namespace App\Core\Database;

use \PDO;

class Statement
{
    protected $pdo;
    protected $query;
    protected $testing = false;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * set the current mode as test
     *
     * @param boolean $value
     * @return void
     */
    public function setTesting($value = true)
    {
        $this->testing = $value;
    }

    public function setQuery(string $query)
    {
        $this->query = $query;
        return $this;
    }

    /**
     *
     * Fetch all data for the sql query
     *
     * @return array
     */
    public function fetchAll($params = [])
    {
        if ($this->testing) {
            return [
                'query' => $this->query,
                'params' => $params
            ];
        }

        try {
            $statement = $this->pdo->prepare($this->query);
            $statement->execute($params);

            return $statement->fetchAll(PDO::FETCH_OBJ);
        } catch (\Exception $e) {
            die($e->getMessage());
        }
    }

    /**
     *
     * Fetch all data for the sql query
     *
     * @return array
     */
    public function fetch($params = [])
    {
        if ($this->testing) {
            return [
                'query' => $this->query,
                'params' => $params
            ];
        }

        try {
            $statement = $this->pdo->prepare($this->query);
            $statement->execute($params);

            return $statement->fetch(PDO::FETCH_OBJ);
        } catch (\Exception $e) {
            die($e->getMessage());
        }
    }

    /**
     *
     * Fetch specified Column
     *
     * @return array
     */
    public function fetchColumn($columnNumber = 0, $params = [])
    {
        if ($this->testing) {
            return [
                'query' => $this->query,
                'params' => $params
            ];
        }

        try {
            $statement = $this->pdo->prepare($this->query);
            $statement->execute($params);

            return $statement->fetchColumn($columnNumber);
        } catch (\Exception $e) {
            die($e->getMessage());
        }
    }

    public function execute($params = [])
    {
        if ($this->testing) {
            return [
                'query' => $this->query,
                'params' => $params
            ];
        }

        try {
            $this->pdo->prepare($this->query)->execute($params);
        } catch (\PDOException $e) {
            die($e->getMessage());
        }
    }
}
