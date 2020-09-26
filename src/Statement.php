<?php

namespace SimpleORM;

use \PDO;

class Statement
{
    protected $pdo;
    protected $query;
    protected $toSql = false;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * set the current mode as test
     *
     * @param bool $value
     * @return Statement $this
     */
    public function setToSql($value = true)
    {
        $this->toSql = $value;
        return $this;
    }

    /**
     * set query attribute
     *
     * @param string $query
     * @return Statement $this
     */
    public function setQuery(string $query)
    {
        $this->query = $query;
        return $this;
    }

    /**
     * fetch all data for the sql query
     *
     * @param array $params
     * @return array
     */
    public function fetchAll($params = [])
    {
        if ($this->toSql) {
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
     * fetch all data for the sql query
     *
     * @param array $params
     * @return array|mixed
     */
    public function fetch($params = [])
    {
        if ($this->toSql) {
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
     * fetch specified Column
     *
     * @param int $columnNumber
     * @param array $params
     * @return array|mixed
     */
    public function fetchColumn($columnNumber = 0, $params = [])
    {
        if ($this->toSql) {
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

    /**
     * execute the query
     *
     * @param array $params
     * @return array|string
     */
    public function execute($params = [])
    {
        if ($this->toSql) {
            return [
                'query' => $this->query,
                'params' => $params
            ];
        }

        try {
            $this->pdo->prepare($this->query)->execute($params);

            return $this->pdo->lastInsertId();
        } catch (\PDOException $e) {
            die($e->getMessage());
        }
    }
}
