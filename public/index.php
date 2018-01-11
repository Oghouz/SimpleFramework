<?php


// App current path

define('APP_PATH', str_replace('\\public', '', __DIR__) . '/');

var_dump(APP_PATH);
// Public path
define('APP_PUBLIC', __DIR__ . DIRECTORY_SEPARATOR .'public');

// Mode debug
define('APP_DEBUG', true);

// include core file
require(APP_PATH . '/core/Core.php');

$config = require(APP_PATH . '/config/config.php');

(new core\Core($config))->run();
