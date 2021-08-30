<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

require '../vendor/autoload.php';
require '../src/config/database.php';
require '../src/config/helper.php';

$app = new \Slim\App();

// Archivo de rutas
require '../src/rutas/rutas.php';

date_default_timezone_set('America/El_Salvador');

$app->run();