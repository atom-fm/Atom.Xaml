<?php

namespace App;

use PDO;

class Database
{
    public function getPdo()
    {
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        switch (APP_DATABASE_DRIVER) {
            case "sqlite":
                $dsn = "sqlite:" . APP_DATABASE_FILE;
                break;
            default:
                $dsn = APP_DATABASE_DRIVER . ":host={$this->host};dbname={$this->database};charset={$this->charset}";
                break;
        }

        return new PDO($dsn, APP_DATABASE_USER, APP_DATABASE_PASSWORD, $options);
    }

    public function queryAll($sql)
    {
        $pdo = $this->getPdo();
        $cursor = $pdo->query($sql);

        $result = [];
        while ($row = $cursor->fetch()) {
            $result[]  = $row;
        }
        return $result;
    }
}
