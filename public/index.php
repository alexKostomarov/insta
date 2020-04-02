<?php
require __DIR__.'/../vendor/autoload.php';

$request = new App\Request();

App\Router::route($request);

?>