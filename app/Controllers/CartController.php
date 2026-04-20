<?php

namespace App\Controllers;

use App\Models\Product;
use App\Models\Cart;

class CartController extends BaseController
{
    private Cart $cartModel;

    public function __construct(Cart $cartModel)
    {
        $this->cartModel = $cartModel;
    }

    public function index()
    {
        $this->render('cart/index', [
            'products' => $this->cartModel->getCartDetails(),
            'total' => $this->cartModel->getCartTotal()
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

        $this->render('cart/checkout', [
            'products' => $this->cartModel->getCartDetails(),
            'total' => $this->cartModel->getCartTotal()
        ]);
    }

    public function processCheckout()
    {
        $this->requireAuth();
        $this->cartModel->clear();
        $this->render('cart/success');
    }
}
