<?php
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
    public function __construct($conn) {
        $this->conn = $conn;
    }

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
    public function updateUser($id, $fullname, $username, $userpassword, $userphone, $useremail, $role, $gender, $age, $address, $img, $subscription) {
        $sql = "UPDATE users SET fullname = ?, username = ?, userpassword = ?, userphone = ?, useremail = ?, role = ?, gender = ?, age = ?, address = ?, img = ?, subscription = ? 
                WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sssssssisssi", $fullname, $username, $userpassword, $userphone, $useremail, $role, $gender, $age, $address, $img, $subscription, $id);

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


 

?>