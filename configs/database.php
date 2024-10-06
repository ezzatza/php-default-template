<?php

define('DB_SERVER', $_ENV['DB_SERVER']);
define('DB_USER', $_ENV['DB_USER']);
define('DB_PASS', $_ENV['DB_PASS']);
define('DB_NAME', $_ENV['DB_NAME']);

$con = new mysqli(DB_SERVER, DB_USER, DB_PASS, DB_NAME);

if ($con->connect_error) {
    die("Database connection error, please fix this error and try again.");
}
