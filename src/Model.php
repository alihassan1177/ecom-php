<?php

namespace App;

use App\Database;

class Model
{
    public static $table_name;

    public static function all()
    {
        return Database::query("SELECT * FROM `" . self::$table_name . "`;");
    }

    public static function findByEmail(string $email)
    {
        return Database::query("SELECT * FROM `" . self::$table_name . "` WHERE `email` = '$email';");
    }
}
