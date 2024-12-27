<?php
require_once __DIR__ . '/model.php';
class User {
    private $conn;

    // Constructor to initialize the database connection
    public function __construct($dbConnection) {
        $this->conn = $dbConnection;
    }

    

    // READ: Fetch all users
    public function getAllUsers() {
        $sql = "SELECT * FROM users";
        $result = $this->conn->query($sql);

        $users = [];
        while ($row = $result->fetch_assoc()) {
            $users[] = $row;
        }

        return $users;
    }

    // READ: Fetch a single user by ID
    public function getUserById($id) {
        $sql = "SELECT * FROM users WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_assoc();
    }

    // UPDATE: Update user details
    public function updateUser($id, $fullname, $username, $password, $phone, $email, $role, $gender, $age, $address, $img, $subscription) {
        $sql = "UPDATE users 
                SET fullname = ?, username = ?, userphone = ?, useremail = ?, role = ?, gender = ?, age = ?, address = ?, img = ?, subscription = ?";

        // Include password in the update if provided
        if (!empty($password)) {
            $sql .= ", userpassword = ?";
        }
        $sql .= " WHERE id = ?";

        $stmt = $this->conn->prepare($sql);

        if (!empty($password)) {
            $stmt->bind_param("sssssssisssi", $fullname, $username, $phone, $email, $role, $gender, $age, $address, $img, $subscription, $password, $id);
        } else {
            $stmt->bind_param("ssssssisssi", $fullname, $username, $phone, $email, $role, $gender, $age, $address, $img, $subscription, $id);
        }

        return $stmt->execute();
    }

    // DELETE: Delete a user
    public function deleteUser($id) {
        $sql = "DELETE FROM users WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);

        return $stmt->execute();
    }
}
?>