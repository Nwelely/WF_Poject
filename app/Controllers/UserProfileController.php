<?php
require_once __DIR__ . '/../model/user.php';
require_once __DIR__ . '/../DB/DB.php';



$userModel = new User($conn);

// Check if the request is POST and if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Fetch user ID from session
    if (!isset($_SESSION['user']) || empty($_SESSION['user']['id'])) {
        header("Location: /WF_Project/views/login-index.php");
        exit();
    }

    $userId = $_SESSION['user']['id'];

    // Retrieve updated user data from POST request
    $fullname = !empty($_POST['fullname']) ? $_POST['fullname'] : $_SESSION['user']['fullname'];
    $username = !empty($_POST['username']) ? $_POST['username'] : $_SESSION['user']['username'];
    $useremail = !empty($_POST['useremail']) ? $_POST['useremail'] : $_SESSION['user']['useremail'];
    $address = !empty($_POST['address']) ? $_POST['address'] : $_SESSION['user']['address'];
    $gender = !empty($_POST['gender']) ? $_POST['gender'] : $_SESSION['user']['gender'];
    $age = !empty($_POST['age']) ? $_POST['age'] : $_SESSION['user']['age'];
    $userphone = !empty($_POST['userphone']) ? $_POST['userphone'] : $_SESSION['user']['userphone'];
    $password = !empty($_POST['password']) ? $_POST['password'] : null;
    $img = $_SESSION['user']['img'] ?? '';
    $subscription = $_SESSION['user']['subscription'] ?? '';
    $role = $_SESSION['user']['role'] ?? '';

    // Handle file upload for profile image (if required)
    if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = __DIR__ . '/../uploads/';
        $uploadFile = $uploadDir . basename($_FILES['profile_image']['name']);

        if (move_uploaded_file($_FILES['profile_image']['tmp_name'], $uploadFile)) {
            $img = $_FILES['profile_image']['name'];
        }
    }

    // Update user in the database
    $updateResult = $userModel->updateUser($userId, $fullname, $username, $password, $userphone, $useremail, $role, $gender, $age, $address, $img, $subscription);

    if ($updateResult) {
        // Update the session data after successful update
        $_SESSION['user']['fullname'] = $fullname;
        $_SESSION['user']['username'] = $username;
        $_SESSION['user']['useremail'] = $useremail;
        $_SESSION['user']['address'] = $address;
        $_SESSION['user']['gender'] = $gender;
        $_SESSION['user']['age'] = $age;
        $_SESSION['user']['userphone'] = $userphone;
        $_SESSION['user']['img'] = $img;

        // Redirect to profile page with success message
        header("Location: /WF_Poject/app/views/Profile.php");
        exit();
    } else {
        // Redirect to profile page with error message
        header("Location: /WF_Project/views/profile.php?error=1");
        exit();
    }
}
?>
