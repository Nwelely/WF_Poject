<?php
session_start(); 
require_once __DIR__ . '/model.php';
class User {
    private $conn;

    // Properties
    private $id;
    private $fullname;
    private $username;
    private $userpassword;
    private $userphone;
    private $useremail;
    private $role;
    private $gender;
    private $age;
    private $address;
    private $img;
    private $subscription;

    // Constructor to initialize the database connection
  
    // CREATE: Add a new user
   
    

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
    // UPDATE: Update user details
public function updateUser($id, $fullname, $username, $userpassword, $userphone, $useremail, $role, $gender, $age, $address, $img, $subscription) {
    // Start with the base query
    $sql = "UPDATE users SET fullname = ?, username = ?, userphone = ?, useremail = ?, role = ?, gender = ?, age = ?, address = ?, img = ?, subscription = ?";

    // Check if a new password is provided
    if (!empty($userpassword)) {
        $sql .= ", userpassword = ?";
    }

    // Complete the query with the WHERE clause
    $sql .= " WHERE id = ?";

    // Prepare the statement
    $stmt = $this->conn->prepare($sql);

    // Bind parameters based on whether the password is updated
    if (!empty($userpassword)) {
        $stmt->bind_param("sssssssisssi", $fullname, $username, $userphone, $useremail, $role, $gender, $age, $address, $img, $subscription, $userpassword, $id);
    } else {
        $stmt->bind_param("ssssssisssi", $fullname, $username, $userphone, $useremail, $role, $gender, $age, $address, $img, $subscription, $id);
    }

    // Execute and return the result
    if ($stmt->execute()) {
        return "User updated successfully.";
    } else {
        return "Error: " . $stmt->error;
    }
}


    // DELETE: Delete a user
    public function deleteUser($id) {
        $sql = "DELETE FROM users WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            return "User deleted successfully.";
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


 
$conn->close();
?>