<?php

namespace App\Controllers;

use App\Models\Product;

class CartController extends BaseController
{
    private Product $productModel;

    public function __construct(Product $productModel)
    {
        $this->productModel = $productModel;
    }

    public function index()
    {
        $cart = $_SESSION['cart'] ?? [];
        $products = [];
        $total = 0;

        foreach ($cart as $id => $quantity) {
            $product = $this->productModel->getById((int)$id);
            if ($product) {
                $product['quantity'] = $quantity;
                $product['subtotal'] = $product['price'] * $quantity;
                $products[] = $product;
                $total += $product['subtotal'];
            }
        }

        $this->render('cart/index', [
            'products' => $products,
            'total' => $total
        ]);
    }

    public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = (int)($_POST['id'] ?? 0);
            if ($id > 0) {
                if (!isset($_SESSION['cart'])) {
                    $_SESSION['cart'] = [];
                }

                if (isset($_SESSION['cart'][$id])) {
                    $_SESSION['cart'][$id]++;
                } else {
                    $_SESSION['cart'][$id] = 1;
                }
            }
        }
        $this->redirect('/');
    }

    public function remove()
    {
        $id = (int)($_GET['id'] ?? 0);
        if ($id > 0 && isset($_SESSION['cart'][$id])) {
            unset($_SESSION['cart'][$id]);
        }
        $this->redirect('/cart');
    }
}
