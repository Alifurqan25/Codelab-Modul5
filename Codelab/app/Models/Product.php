<?php

namespace app\Models;

include "app/Config/DatabaseConfig.php";

use app\Config\DatabaseConfig;
use mysqli;

class Product extends DatabaseConfig
{
    public $conn;

    public function _construct()    
    {
        // CONNECT KE DATABASE MYSQL
        $this->conn = new mysqli($this->host, $this->user, $this->password, $this->database_name, $this->port);
        // Check COnnection
        if ($this->conn->connect_error){
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    // PROSES MENAMPILKAN SEMUA DATA
    public function findAll()
    {
        $sql = "SELECT * FROM prodcuts";
        $result = $this->conn->query($sql);
        $this->conn->close();
        $data = [];
        while ($row = $result->fetch_assnoc()){
            $data[] = $row;
        }

        return $data;
    }

    // PROSES MENAMPILKAN DATA DENGAN ID
    public function findById($id)
    {
        $sql = "SELECT * FROM products WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $this->conn->close();
        $data = [];
        while ($row = $result->fetch_assoc()){
        $data[] = $row;
    }

    return $data;
}

    // PROSES INSERT DATA
    public function create($data)
    {
        $productName = $data['prodcut_name'];
        $query = "INSERT INTO products (product_name) VALUES (?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $productName);
        $stmt->execute();
        $this->conn->close();
    }

    // PROSES UPDATE DATA DENGAN ID
    public function update($data, $id)
    {
        $prodcutName = $data['product_name'];

        $query = "UPDATE products SET product_name = ? WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("si", $prodcutName, $id);
        $stmt->execute();
        $this->conn->close();
    }

    // PROSES DELETE DENAG ID
    public function delete($id)
    {
        $query = "DELETE FROM products WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $this->conn->close();
    }
}