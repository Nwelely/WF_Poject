<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);
ob_start(); // Start output buffering

session_start();

// Include database connection file
require_once '../DB/DB.php';// Adjust the path accordingly

// Sanitize input function
function sanitizeInput($data) {
    global $conn;
    return $data !== null ? mysqli_real_escape_string($conn, trim($data)) : '';
}

// Handle the login process
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'login') {
    $username = sanitizeInput($_POST['username']);
    $password = sanitizeInput($_POST['password']);

    // Query to fetch user by username
    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("s", $username);
    if (!$stmt->execute()) {
        die("Execute failed: " . $stmt->error);
    }

    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        // Verify the password
        if (password_verify($password, $user['userpassword'])) {
            // Successful login
            $_SESSION['user'] = [
                'id' => $user['id'],
                'username' => $user['username'],
                'fullname' => $user['fullname'],
                'useremail' => $user['useremail'],  // Storing email in session
                'address' => $user['address'],      // Storing address in session
                'gender' => $user['gender'],        // Storing gender in session
                'age' => $user['age'],              // Storing age in session
                'userphone' => $user['userphone'],  // Storing phone in session
                'role' => $user['role'] ?? 'user',  // Default to 'user' if role is not set
            ];
            $_SESSION['isLoggedIn'] = true;

            // Redirect to homepage or profile page based on the role
            if ($user['role'] === 'admin') {
                header("Location: http://localhost/WF_Poject/app/views/Admin-index.php"); // Redirect to Admin Dashboard
            } else {
                header("Location: http://localhost/WF_Poject/app/views/index.php"); // Redirect to normal user homepage
            }
            exit();
        } else {
            $loginError = "Invalid username or password."; // Invalid password
        }
    } else {
        $loginError = "Invalid username or password."; // User not found
    }
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../../public/css/Login-Style.css">
</head>
<body>
    <?php include('partials/Navigation-Index.php'); ?>

    <div class="parent-container">
        <div class="form-container" id="login-container">
            <h2>Login Form</h2>

            <!-- Display error message if set -->
            <?php if (isset($loginError)): ?>
                <p style="color: red;"><?php echo $loginError; ?></p>
            <?php endif; ?>

            <form id="login-form" method="post">
                <input type="hidden" name="action" value="login"> <!-- Hidden field for action -->
                
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
                
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
                
                <input type="submit" id="login-button" value="Login">
                <input type="button" id="signup-button" onclick="window.location.href='http://localhost/WF_Poject/app/views/SignUp-index.php';" value="Signup">
                
                <a href="http://localhost/WF_Poject/app/views/reset-password.php" id="forgot-password">Forgot Password?</a>
            </form>
        </div>
    </div>

    <script src="../../public/js/Login-JavaScript.js"></script>
</body>
</html>
