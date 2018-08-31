<?php

namespace Guestbook;

use PDO;

class PdoFactory
{
    private static $pdo = null;

    public function getPDO()
    {
        if (!self::$pdo) {
            $userName =  getenv('DB_USER');
            $password = getenv('DB_PASSWORD');
            self::$pdo = new PDO($this->getDsn(), $userName, $password);
        }

        return self::$pdo;
    }

    private function getDsn(): string
    {
        $host = "mysql";
        $dbName = getenv("DB_NAME");
        $charset = "utf8mb4";
        return "mysql:host={$host};dbname={$dbName};charset={$charset}";
    }
}