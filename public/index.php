<?php
// Define ROOT_PATH and APP_PATH
define('ROOT_PATH', dirname(__DIR__).DIRECTORY_SEPARATOR);
define('APP_PATH', ROOT_PATH.'app'.DIRECTORY_SEPARATOR);

// Register the composer autoloader
require ROOT_PATH.'vendor/autoload.php';
require APP_PATH.'load.php';


// Run application
hirest()->run();