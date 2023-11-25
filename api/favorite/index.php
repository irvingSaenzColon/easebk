<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");
header('Content-Type: application/json; charset=utf-8');

include_once($_SERVER['DOCUMENT_ROOT'].'/ease/controller/favorite.php');
require '../../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable('../../');
$dotenv->safeLoad();

Flight::route("GET /", [new FavoriteController, 'get']);

Flight::route("POST /user", [new FavoriteController(), 'getFavorite']);

Flight::route("GET /from/@id", [new FavoriteController(), 'getFavorites']);

Flight::route("POST /mark", [new FavoriteController(), 'mark']);

Flight::start();