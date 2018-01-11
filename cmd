<?php
/**
echo "Are you sure you want to do this?  Type 'yes' to continue: ";
$handle = fopen ("php://stdin","r");
$line = fgets($handle);
if(trim($line) != 'yes'){
    echo "ABORTING!\n";
    exit;
}
echo "\n";
echo "Thank you, continuing...\n";
 */


if (isset($argv[1]))
{

    if(!isset($argv[2])) {
        echo "You need enter the file name Ex: IndexController\n";
        return;
    }
    $make = $argv[1];
    $name = $argv[2];
    switch ($make) {
        case "make:controller" :
            makeController($name);
            echo "$name created!\n";
            break;
        case "make:model" :
            makeModel($name);
            echo "$name created!\n";
            break;
        default :
            echo $make;
            break;
    }


} else {
    echo "-------- Simple Framework CMD --------\n\n";
    echo "make:controller  -- Make controller file\n";
    echo "make:model       -- Make model file\n";
}

function makeController($name)
{
    if (!$name) return false;

    $controller = "<?php

namespace App\\Controllers;

use Core\\Base\\Controller;

class " . $name . "Controller extends Controller
{

}";
    $file = "app/controllers/" . $name . '.php';
    file_put_contents($file, $controller);
}

function makeModel($name)
{
    if (!$name) return false;

    $model = "<?php

namespace App\\Model;

use Core\\Base\\Model;

class ArticleModel extends Model
{

}";
    $file = "app/models/" . $name . ".php";
    file_put_contents($file, $model);
}