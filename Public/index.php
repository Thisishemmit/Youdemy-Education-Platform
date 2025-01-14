<?php

use Core\Route;
use Core\Router;

session_start();
include '../Helpers/autoload.php';

$router = new Router();
Route::setRouter($router);


Route::dispatch($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
