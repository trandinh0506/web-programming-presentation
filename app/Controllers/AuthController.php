<?php

namespace App\Controllers;

use App\Models\User;

class AuthController extends BaseController
{
    private User $userModel;

    public function __construct(User $userModel)
    {
        $this->userModel = $userModel;
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';


            $user = $this->userModel->findByUsername($username);
            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['user_role'] = $user['role'];
                if ($user['role'] == 'admin') {
                    $this->redirect('/admin/dashboard');
                } else {
                    $this->redirect('/');
                }
            } else {
                $this->render('auth/login', ['error' => 'Invalid credentials']);
                return;
            }
        }

        $this->render('auth/login');
    }

    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = htmlspecialchars($_POST['username'] ?? '');
            $password = $_POST['password'] ?? '';
            $confirm = $_POST['confirm_password'] ?? '';

            if ($password !== $confirm) {
                $this->render('auth/register', ['error' => 'Passwords do not match']);
                return;
            }

            if ($this->userModel->findByUsername($username)) {
                $this->render('auth/register', ['error' => 'Username already exists']);
                return;
            }

            $this->userModel->create($username, $password);
            $this->redirect('/login');
        }

        $this->render('auth/register');
    }

    public function logout()
    {
        session_destroy();
        $this->redirect('/login');
    }
}
