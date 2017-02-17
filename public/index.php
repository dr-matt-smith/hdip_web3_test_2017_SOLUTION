<?php
// the DatabaseManager class needs the following 4 constants to be defined in order to create the DB connection
define('DB_HOST', 'localhost');
define('DB_USER', 'fred');
define('DB_PASS', 'smith');
define('DB_NAME', 'hdip_test');

// load classes
// ---------------------------------------
require_once __DIR__ . '/../vendor/autoload.php';

use Itb\WebApplication;
$app = new WebApplication();
$app->run();