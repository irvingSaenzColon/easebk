<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");
header('Content-Type: application/json; charset=utf-8');

include_once($_SERVER['DOCUMENT_ROOT'].'/ease/controller/vehicle.php');
require '../../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable('../../');
$dotenv->safeLoad();

Flight::route("POST /search", [new VehicleController(), 'search']);
Flight::route("GET /images", [new VehicleController(), 'images']);
Flight::route("GET /latest", [new VehicleController(), 'lastest']);
Flight::route("GET /deals", [new VehicleController(), 'chepeast']);
Flight::route("GET /sellers", [new VehicleController(), 'sellers']);

Flight::start();