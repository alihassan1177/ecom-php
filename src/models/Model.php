<?php

namespace App\models;

use App\core\Database;

class Model
{
    public static $table_name;

    public static function all()
    {
        return Database::getResultsByQuery("SELECT * FROM `" . self::$table_name . "`;");
    }

    public static function findByEmail(string $email)
    {
        return Database::getResultsByQuery("SELECT * FROM `" . self::$table_name . "` WHERE `email` = '$email';");
    }
}
