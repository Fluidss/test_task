<?php
session_start();

use App\Router;

spl_autoload_register(function ($class) {
    include_once strtolower($class) . '.php';
});
$router = new Router;
