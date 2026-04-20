<?php

namespace App\Models;

class Cart
{
    private Product $productModel;

    public function __construct(Product $productModel)
    {
        $this->productModel = $productModel;
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

    public function getCartDetails(): array
    {
        $products = [];
        foreach ($_SESSION['cart'] as $id => $quantity) {
            $product = $this->productModel->getById((int)$id);
            if ($product) {
                $product['quantity'] = $quantity;
                $product['subtotal'] = $product['price'] * $quantity;
                $products[] = $product;
            }
        }
        return $products;
    }

    public function getCartTotal(): float
    {
        $total = 0;
        foreach ($_SESSION['cart'] as $id => $quantity) {
            $product = $this->productModel->getById((int)$id);
            if ($product) {
                $total += $product['price'] * $quantity;
            }
        }
        return $total;
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
