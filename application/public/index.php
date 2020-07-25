<?php

use Bramus\Router\Router;

include_once dirname(__FILE__)."/../vendor/autoload.php";

$router = new Router();

$router->match('GET', '/', '\DattaConsulting\CloudInitIso\Controller\HomeController@index');
$router->match('POST', '/process', '\DattaConsulting\CloudInitIso\Controller\ProcessController@index');

$router->set404(function() {
    header('HTTP/1.1 404 Not Found');
    echo "<center>404 Not Found</center>";
});

$router->run();
