<?php

namespace App;

class Database
{
    private static $conn;
    public static function connect()
    {
        self::$conn = mysqli_connect("localhost", "debian-sys-maint", "9qhIIDtL77fzKTmD", "sms");
    }

    public static function query(string $query)
    {
        $result = mysqli_query(self::$conn, $query);
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    public static function execQuery(string $query)
    {
        mysqli_query(self::$conn, $query);
    }
}
