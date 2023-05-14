<?php

require_once __DIR__ . "/../vendor/autoload.php";

use App\Database;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__."/../");
$dotenv->load();

Database::connect();

session_start();

require_once __DIR__ . "/../src/core/Config.php";

require_once __DIR__ . "/../routes/web.php";
