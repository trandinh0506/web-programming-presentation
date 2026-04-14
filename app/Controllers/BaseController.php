<?php

namespace App\Controllers;

abstract class BaseController
{
    protected function render(string $view, array $data = [])
    {
        extract($data);
        include __DIR__ . "/../Views/layout/header.php";
        include __DIR__ . "/../Views/{$view}.php";
        include __DIR__ . "/../Views/layout/footer.php";
    }

    protected function redirect(string $url)
    {
        header("Location: {$url}");
        exit;
    }
}
