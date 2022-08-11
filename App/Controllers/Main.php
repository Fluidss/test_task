<?php

namespace App\Controllers;

use App\Models\Student;

class Main
{
    public function index()
    {
        $model = new \App\Models\Student();
        \App\Views\View::render('index');
    }
    public function list($sort, $page)
    {
        $model = new \App\Models\Student;
        $pagination = $model->pagination();
        $students =  $model->allStudent($sort, $page);
        \App\Views\View::render('list', ['students' => $students, 'pagination' => $pagination, 'page' => $page]);
    }
    public function addStudent(array $data)
    {
        $model = new \App\Models\Student($data);
        $model->addStudent();
        \App\Views\View::render('index', ['data' => $data]);
    }
}
