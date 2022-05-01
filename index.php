<?php

// Composer autoloader
require_once __DIR__.'/vendor/autoload.php';

use MyApp\Controller\Home;

$homeController = new Home();

$homeController->saveTempByCity('Jerusalem');
$weatherModel = $homeController->getLastTempByCity('Jerusalem');

var_dump($weatherModel->toArray());
die;