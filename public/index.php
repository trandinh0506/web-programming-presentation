<?php

use App\Core\Container;
use App\Core\Database;
use App\Core\Router;
use App\Controllers\ProductController;
use App\Controllers\AdminController;
use App\Controllers\AuthController;
use App\Controllers\CartController;
use App\Models\Product;
use App\Models\User;
use App\Models\Cart;

// Simple PSR-4 Autoloader
spl_autoload_register(function ($class) {
    $prefix = 'App\\';
    $base_dir = __DIR__ . '/../app/';
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) return;
    $relative_class = substr($class, $len);
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';
    if (file_exists($file)) require $file;
});

session_start();

$config = [
    'host' => 'localhost',
    'dbname' => 'ecommerce_db',
    'username' => 'root',
    'password' => ''
];

// Initialize DI Container
$container = new Container();

$container->set(Database::class, function () use ($config) {
    return new Database($config);
});

$container->set(Product::class, function ($c) {
    return new Product($c->get(Database::class));
});

$container->set(User::class, function ($c) {
    return new User($c->get(Database::class));
});

$container->set(Cart::class, function ($c) {
    return new Cart($c->get(Product::class));
});

$container->set(ProductController::class, function ($c) {
    return new ProductController($c->get(Product::class));
});

$container->set(AdminController::class, function ($c) {
    return new AdminController($c->get(Product::class));
});

$container->set(AuthController::class, function ($c) {
    return new AuthController($c->get(User::class));
});

$container->set(CartController::class, function ($c) {
    return new CartController($c->get(Cart::class));
});

// Initialize Router
$router = new Router($container);

// Define Routes
$router->add('GET', '/', ProductController::class, 'index');
$router->add('GET', '/product', ProductController::class, 'show');
$router->add('GET', '/login', AuthController::class, 'login');
$router->add('POST', '/login', AuthController::class, 'login');
$router->add('GET', '/register', AuthController::class, 'register');
$router->add('POST', '/register', AuthController::class, 'register');
$router->add('GET', '/logout', AuthController::class, 'logout');
$router->add('GET', '/admin', AdminController::class, 'index');
$router->add('GET', '/admin/dashboard', AdminController::class, 'index');
$router->add('GET', '/admin/products/edit', AdminController::class, 'edit');
$router->add('POST', '/admin/products/store', AdminController::class, 'store');
$router->add('POST', '/admin/products/update', AdminController::class, 'update');
$router->add('GET', '/admin/products/delete', AdminController::class, 'delete');
$router->add('GET', '/cart', CartController::class, 'index');
$router->add('POST', '/cart/add', CartController::class, 'add');
$router->add('GET', '/cart/remove', CartController::class, 'remove');
$router->add('GET', '/checkout', CartController::class, 'checkout');
$router->add('POST', '/checkout', CartController::class, 'processCheckout');

// Dispatch
$router->dispatch($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
