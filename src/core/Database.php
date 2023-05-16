<?php

namespace App\core;

class Database
{
  private static $conn;

  public static function connect()
  {
    $connection = mysqli_connect($_ENV["DB_HOST"], $_ENV["DB_USER"], $_ENV["DB_PASSWORD"], $_ENV["DB_NAME"]);
    if (!$connection) {
      throw new \Exception("DATABASE CONNECTION FAILED, CHECK SERVER", 1);
      return;
    }
    self::$conn = $connection;
  }

  public static function getResultsByQuery(string $query)
  {
    $result = mysqli_query(self::$conn, $query);
    if (!$result) {
      throw new \Exception("DATABASE GET RESULTS QUERY FAILED \nSQL : $query", 1);
      return false;
    }
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
  }

  public static function onlyExecuteQuery(string $query)
  {
    $result = mysqli_query(self::$conn, $query);
    if (!$result) {
      throw new \Exception("DATABASE GET RESULTS QUERY FAILED \nSQL : $query", 1);
      return false;
    }
    return true;
  }
}
