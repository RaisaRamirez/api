<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

$app = new \slim\App();

include 'usuario.php';
include 'cliente.php';
include 'reporte.php';