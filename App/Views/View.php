<?php

namespace App\Views;

class View
{
    public static function render(string $template,  array $params = [])
    {
        $template = trim($template);
        extract($params, EXTR_SKIP);
        $filePath = dirname(__DIR__) . "/Templates/$template.php";
        if (is_readable($filePath)) {
            include($filePath);
        } else {
            echo " $filePath not found";
            exit();
        }
    }
}
