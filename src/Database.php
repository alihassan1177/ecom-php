<?php

namespace App;

class Database
{
    private static $conn;

    public static function connect()
    {
        self::$conn = mysqli_connect($_ENV["DB_HOST"], $_ENV["DB_USER"], $_ENV["DB_PASSWORD"], $_ENV["DB_NAME"]);
    }

    public static function getResultsByQuery(string $query)
    {
        $result = mysqli_query(self::$conn, $query);
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    public static function onlyExecuteQuery(string $query)
    {
        mysqli_query(self::$conn, $query);
    }
}
