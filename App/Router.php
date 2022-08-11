<?php

namespace App;

class Router
{
    public function __construct()
    {
        $route = $_GET['r'] ?? '';
        $route = trim($route, '/');
        if ($route === '') {
            $main = new \App\Controllers\Main;
            $main->index();
        } elseif ($route === 'add') {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                header('Location:/');
            } else {
                $main = new \App\Controllers\Main;
                $main->addStudent($_POST);
            }
        } elseif ($route === 'list') {
            $list = new \App\Controllers\Main;
            $page = $_GET['page'] ?? 1;
            $list->list($_GET, $page);
        } else {
            \App\Views\View::render('404');
        }
    }
}
