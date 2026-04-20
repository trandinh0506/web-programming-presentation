<?php

namespace App\Models;

class Cart
{
    public function __construct()
    {
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
    }

    public function addItem(int $id)
    {
        if (isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id]++;
        } else {
            $_SESSION['cart'][$id] = 1;
        }
    }

    public function removeItem(int $id)
    {
        if (isset($_SESSION['cart'][$id])) {
            unset($_SESSION['cart'][$id]);
        }
    }

    public function getItems(): array
    {
        return $_SESSION['cart'];
    }

    public function clear()
    {
        $_SESSION['cart'] = [];
    }

    public function isEmpty(): bool
    {
        return empty($_SESSION['cart']);
    }
}
