<?php
session_start();

// Check if user is logged in and has the role 'admin'
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header("Location: Login-index.php"); // Redirect to login if not admin
    exit();
}

include_once("../model/user.php");
include_once("../model/product.php");
include_once("../config/DB.php");

$user = new User($conn);
$product = new Product($conn);

$action = $_GET['action'] ?? null;
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../public/css/Admin-Style.css">
</head>
<body>
    <?php include('partials/Navigation-Index.php'); ?>

    <div id="admin_Panel">
        <h2>Admin Panel</h2>
        <ul class="admin-menu">
            <li><a href="admin-index.php?action=view_all_users" class="main-menu-button">View All Users</a></li>
            <li><a href="admin-index.php?action=view_all_products" class="main-menu-button">View All Products</a></li>
        </ul>
    </div>

    <div class="container">
        <h1>Admin Dashboard</h1>
        <div class="action-container">

        <?php
        if ($action === 'view_all_users') {
            $users = $user->getAllUsers();
            echo "<h3>All Users</h3>";
            if (!empty($users)) {
                echo "<table border='1'>
                        <tr>
                            <th>ID</th>
                            <th>Full Name</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Actions</th>
                        </tr>";
                foreach ($users as $u) {
                    echo "<tr>
                            <td>{$u['id']}</td>
                            <td>{$u['fullname']}</td>
                            <td>{$u['username']}</td>
                            <td>{$u['useremail']}</td>
                            <td>
                                <a href='admin-index.php?action=view_user&id={$u['id']}'>View</a> |
                                <a href='admin-index.php?action=edit_user&id={$u['id']}'>Edit</a> |
                                <a href='admin-index.php?action=delete_user&id={$u['id']}'>Delete</a>
                            </td>
                        </tr>";
                }
                echo "</table>";
            } else {
                echo "No users found.";
            }
        } elseif ($action === 'view_user') {
            $userId = $_GET['id'] ?? null;
            if ($userId) {
                $userData = $user->getUserById($userId);
                if ($userData) {
                    echo "<h3>User Details</h3>";
                    echo "<p>ID: {$userData['id']}</p>";
                    echo "<p>Full Name: {$userData['fullname']}</p>";
                    echo "<p>Username: {$userData['username']}</p>";
                    echo "<p>Email: {$userData['useremail']}</p>";
                    echo "<p>Phone: {$userData['userphone']}</p>";
                    echo "<p>Role: {$userData['role']}</p>";
                } else {
                    echo "User not found.";
                }
            }
        } elseif ($action === 'edit_user') {
            $userId = $_GET['id'] ?? null;
            if ($userId) {
                $userData = $user->getUserById($userId);
                if ($userData) {
                    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                        $fullname = $_POST['fullname'];
                        $username = $_POST['username'];
                        $useremail = $_POST['useremail'];
                        $userphone = $_POST['userphone'];
                        $role = $_POST['role'];
                        $gender = $_POST['gender'];
                        $age = $_POST['age'];
                        $address = $_POST['address'];
                        $subscription = $_POST['subscription'];
                        $result = $user->updateUser(
                            $userId,
                            $fullname,
                            $username,
                            null,
                            $userphone,
                            $useremail,
                            $role,
                            $gender,
                            $age,
                            $address,
                            null,
                            $subscription
                        );
                        echo $result;
                    } else {
                        echo "<h3>Edit User</h3>";
                        echo "<form method='POST'>
                                <label>Full Name:</label><input type='text' name='fullname' value='{$userData['fullname']}' required><br>
                                <label>Username:</label><input type='text' name='username' value='{$userData['username']}' required><br>
                                <label>Email:</label><input type='email' name='useremail' value='{$userData['useremail']}' required><br>
                                <label>Phone:</label><input type='text' name='userphone' value='{$userData['userphone']}' required><br>
                                <label>Role:</label><input type='text' name='role' value='{$userData['role']}' required><br>
                                <label>Gender:</label><input type='text' name='gender' value='{$userData['gender']}' required><br>
                                <label>Age:</label><input type='number' name='age' value='{$userData['age']}' required><br>
                                <label>Address:</label><input type='text' name='address' value='{$userData['address']}' required><br>
                                <label>Subscription:</label><input type='text' name='subscription' value='{$userData['subscription']}' required><br>
                                <button type='submit'>Update</button>
                              </form>";
                    }
                }
            }
        }

        if ($action === 'view_all_products') {
            $products = $product->getAllProducts();
            echo "<h3>All Products</h3>";
            if (!empty($products)) {
                echo "<table border='1'>
                        <tr>
                            <th>ID</th>
                            <th>Product Name</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Actions</th>
                        </tr>";
                foreach ($products as $p) {
                    echo "<tr>
                            <td>{$p['id']}</td>
                            <td>{$p['productname']}</td>
                            <td>{$p['price']}</td>
                            <td>{$p['quantity']}</td>
                            <td>
                                <a href='admin-index.php?action=view_product&id={$p['id']}'>View</a> |
                                <a href='admin-index.php?action=edit_product&id={$p['id']}'>Edit</a> |
                                <a href='admin-index.php?action=delete_product&id={$p['id']}'>Delete</a>
                            </td>
                        </tr>";
                }
                echo "</table>";
            }
        }
        ?>
    </div>
</body>
</html>
