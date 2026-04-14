<?php

namespace App\Controllers;

use App\Models\Product;

class ProductController extends BaseController
{
    private Product $productModel;

    public function __construct(Product $productModel)
    {
        $this->productModel = $productModel;
    }

    public function index()
    {
        $cat = $_GET['cat'] ?? null;
        $price = $_GET['price'] ?? null;

        $products = $this->productModel->getAll(['cat' => $cat, 'price' => $price]);
        $categoriesSet = $this->productModel->getCategories();

        $this->render('products/index', [
            'products' => $products,
            'categories' => $categoriesSet,
            'cat' => $cat,
            'price' => $price
        ]);
    }

    public function show()
    {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            $this->redirect('/');
        }

        $product = $this->productModel->getById((int)$id);
        if (!$product) {
            $this->redirect('/');
        }
        
        $this->render('products/show', ['product' => $product]);
    }
}
