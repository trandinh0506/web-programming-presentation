<?php

namespace App\Models;

use App\Core\Database;

class Product
{
    private Database $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function getAll(array $filters = [])
    {
        $sql = "SELECT * FROM products WHERE 1=1";
        $params = [];

        if (isset($filters['cat']) && !empty($filters['cat'])) {
            $sql .= " AND category = :category";
            $params['category'] = $filters['cat'];
        }

        if (isset($filters['price']) && !empty($filters['price'])) {
            $sql .= " AND price <= :price";
            $params['price'] = $filters['price'];
        }

        return $this->db->query($sql, $params)->fetchAll();
    }

    public function getById(int $id)
    {
        return $this->db->query("SELECT * FROM products WHERE id = :id", ['id' => $id])->fetch();
    }

    public function create(array $data)
    {
        $sql = "INSERT INTO products (name, price, description, image, category) 
                VALUES (:name, :price, :description, :image, :category)";
        return $this->db->query($sql, $data);
    }

    public function update(int $id, array $data)
    {
        $sql = "UPDATE products SET name = :name, price = :price, description = :description, 
                image = :image, category = :category WHERE id = :id";
        $data['id'] = $id;
        return $this->db->query($sql, $data);
    }

    public function delete(int $id)
    {
        return $this->db->query("DELETE FROM products WHERE id = :id", ['id' => $id]);
    }

    public function getCategories()
    {
        return $this->db->query("SELECT DISTINCT category FROM products WHERE category IS NOT NULL AND category != ''")->fetchAll();
    }

    public function handleUpload(): ?string
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
