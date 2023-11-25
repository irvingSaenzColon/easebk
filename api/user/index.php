<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");
header('Content-Type: application/json; charset=utf-8');

include_once($_SERVER['DOCUMENT_ROOT'].'/ease/controller/user.php');
require '../../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable('../../');
$dotenv->safeLoad();

Flight::route("GET /", [new UserController(), 'getAll']);

Flight::route("GET /@id", [new UserController(), 'get']);

Flight::route('PUT /update', [new UserController(), 'update']);

Flight::route('DELETE /delete/@id', [new UserController(), 'delete']);

Flight::start();