<?php
require_once __DIR__ . '/model.php';
class Product {
    private $conn;

    // Properties
    private $id;
    private $productname;
    private $price;
    private $quantity;

    // Constructor to initialize the database connection
    public function __construct($conn) {
        $this->conn = $conn;
    }

    // CREATE: Add a new product
    public function addProduct($productname, $price, $quantity) {
        $sql = "INSERT INTO products (productname, price, quantity) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sdi", $productname, $price, $quantity);
    
        if ($stmt->execute()) {
            return "Product added successfully.";
        } else {
            return "Error: " . $stmt->error;
        }
    }

    // READ: Fetch all products
    public function getAllProducts() {
        $sql = "SELECT * FROM products";
        $result = $this->conn->query($sql);

        $products = [];
        while ($row = $result->fetch_assoc()) {
            $products[] = $row;
        }
        return $products;
    }

    // READ: Fetch a single product by ID
    public function getProductById($id) {
        $sql = "SELECT * FROM products WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    // UPDATE: Update product details
    public function updateProduct($id, $productname, $price, $quantity) {
        // Correct SQL query with 4 placeholders
        $sql = "UPDATE products SET productname = ?, price = ?, quantity = ? WHERE id = ?";
        
        $stmt = $this->conn->prepare($sql);
        
        $stmt->bind_param("sssi", $productname, $price, $quantity, $id);
    
        if ($stmt->execute()) {
            return "Product updated successfully.";
        } else {
            return "Error: " . $stmt->error;
        }
    }

    // DELETE: Delete a product
    public function deleteProduct($id) {
        $sql = "DELETE FROM products WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            return "Product deleted successfully.";
        } else {
            return "Error: " . $stmt->error;
        }
    }

    // Destructor to close the database connection
    public function __destruct() {
        // The connection is closed in the script that created this object.
    }
}

// Example usage


 

?>