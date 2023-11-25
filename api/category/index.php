<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");
header('Content-Type: application/json; charset=utf-8');

include_once($_SERVER['DOCUMENT_ROOT'].'/ease/controller/category.php');
require '../../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable('../../');
$dotenv->safeLoad();

Flight::route("GET /", [new CategoryController(), 'getAll']);

Flight::route("GET /@id", [new CategoryController, 'get']);

Flight::route("POST /create", [new CategoryController(), 'create']);

Flight::route("PUT /update", [new CategoryController(), 'update']);

Flight::route("DELETE /@id", [new CategoryController(), 'delete']);

Flight::start();