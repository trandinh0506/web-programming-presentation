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
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validation
            $name = htmlspecialchars($_POST['name'] ?? '');
            $price = (float)($_POST['price'] ?? 0);
            $description = htmlspecialchars($_POST['description'] ?? '');
            $category = htmlspecialchars($_POST['category'] ?? '');

            // File Upload
            $imagePath = $this->handleUpload();

            $this->productModel->create([
                'name' => $name,
                'price' => $price,
                'description' => $description,
                'image' => $imagePath,
                'category' => $category
            ]);

            header('Location: /admin/dashboard');
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
            if (!$product) {
                $this->redirect('/admin/dashboard');
            }

            $name = htmlspecialchars($_POST['name'] ?? '');
            $price = (float)($_POST['price'] ?? 0);
            $description = htmlspecialchars($_POST['description'] ?? '');
            $category = htmlspecialchars($_POST['category'] ?? '');

            // Keep old image if no new one uploaded
            $imagePath = $this->handleUpload() ?: $product['image'];

            $this->productModel->update($id, [
                'name' => $name,
                'price' => $price,
                'description' => $description,
                'image' => $imagePath,
                'category' => $category
            ]);

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

    private function handleUpload(): ?string
    {
        if (!isset($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
            return null;
        }

        $uploadDir = __DIR__ . '/../../public/uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $filename = uniqid() . '_' . basename($_FILES['image']['name']);
        $targetPath = $uploadDir . $filename;

        // Check file type (basic)
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];
        $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

        if (in_array($ext, $allowed)) {
            if (move_uploaded_file($_FILES['image']['tmp_name'], $targetPath)) {
                return $filename;
            }
        }

        return null;
    }
}
