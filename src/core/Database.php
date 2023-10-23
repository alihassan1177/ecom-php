<?php

namespace App\core;

use App\traits\Singleton;

class Database
{

  use Singleton;

  private $conn;

  public function __construct() {
    $this->connect();
  }

  public function connect()
  {
    $connection = mysqli_connect($_ENV["DB_HOST"], $_ENV["DB_USER"], $_ENV["DB_PASSWORD"], $_ENV["DB_NAME"]);
    if (!$connection) {
      throw new \Exception("DATABASE CONNECTION FAILED, CHECK SERVER", 1);
      return;
    }
    $this->conn = $connection;
  }

  public function getResultsByQuery(string $query)
  {
    $result = mysqli_query($this->conn, $query);
    if (!$result) {
      throw new \Exception("DATABASE GET RESULTS QUERY FAILED \nSQL : $query", 1);
      return false;
    }
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
  }

  public function onlyExecuteQuery(string $query)
  {
    $result = mysqli_query($this->conn, $query);
    if (!$result) {
      throw new \Exception("DATABASE GET RESULTS QUERY FAILED \nSQL : $query", 1);
      return false;
    }
    return true;
  }
}
