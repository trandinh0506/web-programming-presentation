<?php

namespace App\Controllers;

use App\Models\Product;
use App\Models\Cart;

class CartController extends BaseController
{
    private Product $productModel;
    private Cart $cartModel;

    public function __construct(Product $productModel, Cart $cartModel)
    {
        $this->productModel = $productModel;
        $this->cartModel = $cartModel;
    }

    public function index()
    {
        $items = $this->cartModel->getItems();
        $products = [];
        $total = 0;

        foreach ($items as $id => $quantity) {
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
        $this->requireAuth();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = (int)($_POST['id'] ?? 0);
            if ($id > 0) {
                $this->cartModel->addItem($id);
            }
        }
        $this->redirect('/cart');
    }

    public function remove()
    {
        $id = (int)($_GET['id'] ?? 0);
        if ($id > 0) {
            $this->cartModel->removeItem($id);
        }
        $this->redirect('/cart');
    }

    public function checkout()
    {
        $this->requireAuth();
        if ($this->cartModel->isEmpty()) {
            $this->redirect('/cart');
        }

        $items = $this->cartModel->getItems();
        $products = [];
        $total = 0;
        foreach ($items as $id => $quantity) {
            $product = $this->productModel->getById((int)$id);
            if ($product) {
                $product['quantity'] = $quantity;
                $product['subtotal'] = $product['price'] * $quantity;
                $products[] = $product;
                $total += $product['subtotal'];
            }
        }

        $this->render('cart/checkout', [
            'products' => $products,
            'total' => $total
        ]);
    }

    public function processCheckout()
    {
        $this->requireAuth();
        $this->cartModel->clear();
        $this->render('cart/success');
    }
}
