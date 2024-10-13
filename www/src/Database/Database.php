<?php

namespace App\Database;

use App\Exception\DatabaseException;
use PDO;

class Database
{
    private string $host;
    private string $user;
    private string $pass;
    private string $dbname;
    private $pdo;

    public function __construct(string $host, string $user, string $pass, string $dbname)
    {
        $this->host = $host;
        $this->user = $user;
        $this->pass = $pass;
        $this->dbname = $dbname;

        $dsn = "mysql:host=$this->host;dbname=$this->dbname";
        $this->pdo = new PDO($dsn, $this->user, $this->pass);
    }

    public function query($sql, $params = [])
    {
        $stmt = $this->pdo->prepare($sql);

        $stmt->execute($params);

        $errors = $stmt->errorInfo();

        if ('00000' !== $errors[0]) {
            throw new DatabaseException($errors[2]);
        }

        return $stmt;
    }

    public function lastInsertId()
    {
        return $this->pdo->lastInsertId();
    }
}
