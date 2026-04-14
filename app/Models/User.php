<?php

namespace App\Models;

use App\Core\Database;

class User
{
    private Database $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function findByUsername(string $username)
    {
        return $this->db->query("SELECT * FROM users WHERE username = :username", ['username' => $username])->fetch();
    }

    public function create(string $username, string $password, string $role = 'user')
    {
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        return $this->db->query("INSERT INTO users (username, password, role) VALUES (:username, :password, :role)", [
            'username' => $username,
            'password' => $hashed,
            'role' => $role
        ]);
    }
}
