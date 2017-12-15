<?php


// App current path
define('APP_PATH', __DIR__ . '/');

// Mode debug
define('APP_DEBUG', true);

// include core file
require(APP_PATH . '/../core/Core.php');

$config = require(APP_PATH . '/../config/config.php');

(new core\Core($config))->run();
