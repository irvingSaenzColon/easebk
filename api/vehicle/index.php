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

Flight::route("GET /", [new VehicleController(), 'getAll']);
Flight::route("GET /@id", [new VehicleController(), 'get']);
Flight::route("GET /belongs/@id", [new VehicleController(), 'getMyCars']);
Flight::route("POST /create", [new VehicleController(), 'create']);
Flight::route("PUT /update", [new VehicleController(), 'update']);
Flight::route("DELETE /@id", [new VehicleController(), 'delete']);

Flight::start();