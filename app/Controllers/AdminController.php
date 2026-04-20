<?php

namespace App\Controllers;

use App\Models\Product;

class AdminController extends BaseController
{
    private Product $productModel;

    public function __construct(Product $productModel)
    {
        $this->productModel = $productModel;
    }

    private function checkAuth()
    {
        if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
            $this->redirect('/login');
        }
    }

    public function index()
    {
        $this->checkAuth();
        $products = $this->productModel->getAll();
        $this->render('admin/dashboard', ['products' => $products]);
    }

    public function store()
    {
        $this->checkAuth();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->productModel->create([
                'name' => htmlspecialchars($_POST['name'] ?? ''),
                'price' => (float)($_POST['price'] ?? 0),
                'description' => htmlspecialchars($_POST['description'] ?? ''),
                'image' => $this->productModel->handleUpload(),
                'category' => htmlspecialchars($_POST['category'] ?? '')
            ]);

            $this->redirect('/admin/dashboard');
        }
    }

    public function edit()
    {
        $this->checkAuth();
        $id = (int)($_GET['id'] ?? 0);
        $product = $this->productModel->getById($id);
        if (!$product) {
            $this->redirect('/admin/dashboard');
        }
        $this->render('admin/edit', ['product' => $product]);
    }

    public function update()
    {
        $this->checkAuth();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = (int)($_POST['id'] ?? 0);
            $product = $this->productModel->getById($id);
            if ($product) {
                $this->productModel->update($id, [
                    'name' => htmlspecialchars($_POST['name'] ?? ''),
                    'price' => (float)($_POST['price'] ?? 0),
                    'description' => htmlspecialchars($_POST['description'] ?? ''),
                    'image' => $this->productModel->handleUpload() ?: $product['image'],
                    'category' => htmlspecialchars($_POST['category'] ?? '')
                ]);
            }

            $this->redirect('/admin/dashboard');
        }
    }

    public function delete()
    {
        $this->checkAuth();
        $id = (int)($_GET['id'] ?? 0);
        if ($id > 0) {
            $this->productModel->delete($id);
        }
        $this->redirect('/admin/dashboard');
    }
}
