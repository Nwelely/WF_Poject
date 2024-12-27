<?php
require_once("../Controllers/Controller.php");
require_once '../model/product.php'; // Include the Product model

class ProductController {
    private $productModel;

    // Constructor to initialize the Product model
    public function __construct($dbConnection) {
        $this->productModel = new Product($dbConnection);
    }

    // Handle adding a new product
    public function addProduct($data) {
        try {
            // Validate input data
            if (empty($data['productname']) || !isset($data['price']) || !isset($data['quantity'])) {
                throw new Exception("Invalid input data. All fields are required.");
            }

            $result = $this->productModel->addProduct(
                $data['productname'],
                $data['price'],
                $data['quantity']
            );

            return $result;
        } catch (Exception $e) {
            return "Error: " . $e->getMessage();
        }
    }

    // Handle fetching all products
    public function getAllProducts() {
        try {
            return $this->productModel->getAllProducts();
        } catch (Exception $e) {
            return "Error: " . $e->getMessage();
        }
    }

    // Handle fetching a single product by ID
    public function getProductById($id) {
        try {
            if (empty($id)) {
                throw new Exception("Product ID is required.");
            }

            return $this->productModel->getProductById($id);
        } catch (Exception $e) {
            return "Error: " . $e->getMessage();
        }
    }

    // Handle updating a product
    public function updateProduct($data) {
        try {
            // Validate input data
            if (empty($data['id']) || empty($data['productname']) || !isset($data['price']) || !isset($data['quantity'])) {
                throw new Exception("Invalid input data. All fields are required.");
            }

            $result = $this->productModel->updateProduct(
                $data['id'],
                $data['productname'],
                $data['price'],
                $data['quantity']
            );

            return $result;
        } catch (Exception $e) {
            return "Error: " . $e->getMessage();
        }
    }

    // Handle deleting a product
    public function deleteProduct($id) {
        try {
            if (empty($id)) {
                throw new Exception("Product ID is required.");
            }

            return $this->productModel->deleteProduct($id);
        } catch (Exception $e) {
            return "Error: " . $e->getMessage();
        }
    }
}

?>
