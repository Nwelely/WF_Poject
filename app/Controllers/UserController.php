<?php
require_once("../Controllers/Controller.php");
require_once '../model/user.php'; // Include the User model

class UserController {
    private $userModel;

    // Constructor to initialize the User model
    public function __construct($dbConnection) {
        $this->userModel = new User($dbConnection);
    }

    // Handle fetching all users
    public function getAllUsers() {
        try {
            $users = $this->userModel->getAllUsers();
            return $users;
        } catch (Exception $e) {
            return "Error: " . $e->getMessage();
        }
    }

    // Handle fetching a single user by ID
    public function getUserById($id) {
        try {
            return $this->userModel->getUserById($id);
        } catch (Exception $e) {
            return "Error: " . $e->getMessage();
        }
    }

    // Handle updating a user
    public function updateUser($data) {
        try {
            // Validate input data
            if (empty($data['id']) || !isset($data['fullname'])) {
                throw new Exception("Invalid input data.");
            }

            $result = $this->userModel->updateUser(
                $data['id'],
                $data['fullname'],
                $data['username'],
                $data['userpassword'],
                $data['userphone'],
                $data['useremail'],
                $data['role'],
                $data['gender'],
                $data['age'],
                $data['address'],
                $data['img'],
                $data['subscription']
            );

            return $result;
        } catch (Exception $e) {
            return "Error: " . $e->getMessage();
        }
    }

    // Handle deleting a user
    public function deleteUser($id) {
        try {
            return $this->userModel->deleteUser($id);
        } catch (Exception $e) {
            return "Error: " . $e->getMessage();
        }
    }

    // Handle creating a user
   
}

?>
