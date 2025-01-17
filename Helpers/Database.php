<?php

namespace Helpers;

use PDO;
use PDOException;

class Database
{
    private $host;
    private $username;
    private $password;
    private $dbname;
    private $conn = null;
    private $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ];

    public function __construct(
        $username = 'root',
        $password = '',
        $dbname = 'Youdemy',
        $host = 'localhost'
    ) {
        $this->username = $username;
        $this->password = $password;
        $this->dbname = $dbname;
        $this->host = $host;
    }

    public function isConnected()
    {
        return $this->conn !== null;
    }

    public function connect()
    {
        if (!$this->isConnected()) {
            try {
                $dsn = "mysql:host=$this->host;dbname=$this->dbname";
                $this->conn = new PDO($dsn, $this->username, $this->password, $this->options);
                return true;
            } catch (PDOException $e) {
                return false;
            }
        }
    }

    public function disconnect()
    {
        $this->conn = null;
    }

    public function query($sql, $params = [])
    {
        if ($this->isConnected()) {
            $stmt = $this->conn->prepare($sql);
            $stmt->execute($params);
            return $stmt;
        } else {
            return false;
        }
    }

    public function fetch($sql, $params = [])
    {
        $stmt = $this->query($sql, $params);
        return $stmt->fetch();
    }

    public function fetchAll($sql, $params = [])
    {
        $stmt = $this->query($sql, $params);
        return $stmt->fetchAll();
    }

    public function lastInsertId()
    {
        return $this->conn->lastInsertId();
    }
}
