<?php

namespace Guestbook;

use PDO;

class PdoFactory
{
    private $pdo = null;

    public function getPDO()
    {
        if (!$this->pdo) {
            $userName =  getenv('DB_USER');
            $password = getenv('DB_PASSWORD');
            $this->pdo = new PDO($this->getDsn(), $userName, $password);
        }

        return $this->pdo;
    }

    private function getDsn(): string
    {
        $host = "mysql";
        $dbName = getenv("DB_NAME");
        $charset = "utf8mb4";
        return "mysql:host={$host};dbname={$dbName};charset={$charset}";
    }
}