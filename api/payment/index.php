<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");
header('Content-Type: application/json; charset=utf-8');

include_once($_SERVER['DOCUMENT_ROOT'].'/ease/controller/payment.php');
require '../../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable('../../');
$dotenv->safeLoad();

Flight::route("GET /", [new PaymentController(), 'getAll']);

Flight::route("GET /@id", [new PaymentController, 'get']);

Flight::route("GET /from/@id", [new PaymentController, 'getFrom']);

Flight::route("POST /create", [new PaymentController(), 'create']);

Flight::route("PUT /update", [new PaymentController(), 'update']);

Flight::route("DELETE /@id", [new PaymentController(), 'delete']);

Flight::start();