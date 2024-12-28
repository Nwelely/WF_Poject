<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup</title>
    <link rel="stylesheet" href="../../public/css/Login-Style.css">
    <link rel="stylesheet" href="../../public/css/Signup-Style.css">
</head>

<body>
    <?php
    require_once '../Controllers/SignupController.php';
    require_once '../DB/DB.php';
    include('partials/Navigation-Index.php');

    // Enable error reporting for debugging
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    // Function to sanitize user input
    function sanitizeInput($data)
    {
        global $conn;
        return $data !== null ? htmlspecialchars(mysqli_real_escape_string($conn, trim($data))) : '';
    }

    // Variable to hold validation messages
    $validationMessage = "";

    // Check if the form is submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['signup'])) {
        $fullname = sanitizeInput($_POST['fullname']);
        $username = sanitizeInput($_POST['username']);
        $userpassword = sanitizeInput($_POST['userpassword']);
        $userphone = sanitizeInput($_POST['userphone']);
        $useremail = sanitizeInput($_POST['useremail']);
        $role = sanitizeInput($_POST['role']);
        $gender = sanitizeInput($_POST['gender']);
        $age = sanitizeInput($_POST['age']);
        $address = sanitizeInput($_POST['address']);
        $subscription = sanitizeInput($_POST['subscription']);

        // Check if passwords match
        if ($_POST['userpassword'] !== $_POST['confirm-password']) {
            $validationMessage = "<div class='validation-message'>Passwords do not match.</div>";
        }

        // Handle file upload
        $img = null;
        $targetDir = "uploads/";

        // Ensure the upload directory exists and is writable
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0755, true);
        }

        if (isset($_FILES['img']) && $_FILES['img']['error'] === 0) {
            $imgPath = $targetDir . basename($_FILES['img']['name']);
            $fileType = strtolower(pathinfo($imgPath, PATHINFO_EXTENSION));

            // Validate file type (allow only images)
            $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
            if (!in_array($fileType, $allowedTypes)) {
                $validationMessage = "<div class='validation-message'>Invalid image file type. Only JPG, JPEG, PNG, and GIF are allowed.</div>";
            } else {
                if (!move_uploaded_file($_FILES['img']['tmp_name'], $imgPath)) {
                    $validationMessage = "<div class='validation-message'>Failed to upload image.</div>";
                } else {
                    $img = $imgPath;
                }
            }
        }

        // Check if the user already exists in the database
        if (empty($validationMessage)) {
            $checkUser = "SELECT * FROM users WHERE username=? OR useremail=? OR userphone=?";
            $stmt = $conn->prepare($checkUser);
            $stmt->bind_param("sss", $username, $useremail, $userphone);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $validationMessage = "<div class='validation-message'>User already exists.</div>";
                if ($img) {
                    unlink($img); // Remove uploaded image if user exists
                }
            } else {
                // Hash the password before storing it
                $hashedPassword = password_hash($userpassword, PASSWORD_DEFAULT);

                // Insert user data into the database
                $sql = "INSERT INTO users (fullname, username, userpassword, userphone, useremail, role, gender, age, address, img, subscription) 
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("sssssssisss", $fullname, $username, $hashedPassword, $userphone, $useremail, $role, $gender, $age, $address, $img, $subscription);

                if ($stmt->execute()) {
                    // Get the ID of the newly inserted user
                    $user_id = $stmt->insert_id;

                    // Create a cart for the new user
                    $cart_sql = "INSERT INTO carts (user_id) VALUES (?)";
                    $cart_stmt = $conn->prepare($cart_sql);
                    $cart_stmt->bind_param("i", $user_id);
                    $cart_stmt->execute();

                    // Redirect to login page after successful signup
                    header("Location: http://localhost/WF_Poject/app/views/Login-index.php");
                    exit();
                } else {
                    $validationMessage = "<div class='validation-message'>Error: " . $conn->error . "</div>";
                    if ($img) {
                        unlink($img); // Remove the uploaded image if there's an error
                    }
                }
            }
        }
    }
    ?>

    <!-- HTML Signup Form -->
    <div class="form-container" id="signup-container">
        <h2>Signup</h2>
        <?php if ($validationMessage): ?>
            <?php echo $validationMessage; ?>
        <?php endif; ?>
        <form id="signup-form" method="post" enctype="multipart/form-data">
            <div class="row">
                <div class="left-column">
                    <label for="signup-fullname">Full Name:</label>
                    <input type="text" id="signup-fullname" name="fullname" required>

                    <label for="signup-username">Username:</label>
                    <input type="text" id="signup-username" name="username" required>

                    <label for="signup-phone">Phone:</label>
                    <input type="text" id="signup-phone" name="userphone" required>

                    <label for="signup-password">Password:</label>
                    <input type="password" id="signup-password" name="userpassword" required>

                    <label for="signup-address">Address:</label>
                    <input type="text" id="signup-address" name="address" required>

                    <label for="signup-role">Role:</label>
                    <select id="signup-role" name="role" required>
                        <option value="">Select</option>
                        <option value="admin">Admin</option>
                        <option value="user">User</option>
                    </select>
                </div>

                <div class="right-column">
                    <label for="signup-email">Email:</label>
                    <input type="email" id="signup-email" name="useremail" required>

                    <label for="signup-age">Age:</label>
                    <input type="number" id="signup-age" name="age" required>

                    <label for="signup-gender">Gender:</label>
                    <select id="signup-gender" name="gender" required>
                        <option value="">Select</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                    </select>

                    <label for="confirm-password">Confirm Password:</label>
                    <input type="password" id="confirm-password" name="confirm-password" required>

                    <label for="signup-img">Profile Image:</label>
                    <input type="file" id="signup-img" name="img" accept="image/*">

                    <label for="signup-subscription">Subscription:</label>
                    <select id="signup-subscription" name="subscription" required>
                        <option value="">Select</option>
                        <option value="free">Free</option>
                        <option value="premium">Premium</option>
                    </select>
                </div>
            </div>

            <button type="submit" name="signup" class="signup-container-button">Signup</button>
            <button type="button" class="back-to-login" onclick="window.location.href='http://localhost/WF_Poject/app/views/Login-index.php';">Back to Login</button>
        </form>
    </div>

    <script src="../../public/js/Login-JavaScript.js"></script>
</body>

</html>
