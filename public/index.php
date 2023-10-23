<?php

require_once __DIR__ . "/../vendor/autoload.php";

use App\core\Database;

try {
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . "/../");
    $dotenv->load();
} catch (\Exception $e) {
    echo ".env file not found in current directory.";
    exit();
}

Database::getInstance();

session_start();

require_once __DIR__ . "/../src/core/Config.php";
require_once __DIR__ . "/../routes/web.php";
