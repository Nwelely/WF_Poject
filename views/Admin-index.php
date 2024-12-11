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
    include_once("../model/user.php");
    include_once("../model/product.php");
    include_once("../config/DB.php");

    // Instantiate the User class
    $user = new User($conn);

    // Check which action to perform
    $action = $_GET['action'] ?? null;

    if ($action === 'view_all_users') {
        // Fetch and display all users
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
            // Add buttons for Add Admin and Add User
            echo "<button onclick=\"window.location.href='SignUp-index.php?role=admin';\" style='display: inline-block; padding: 10px 20px; margin-top: 30px; background-color: #4CAF50; color: white; border: none; border-radius: 5px; float: left;'>Add Admin</button>";
            echo "<button onclick=\"window.location.href='SignUp-index.php?role=user';\" style='display: inline-block; padding: 10px 20px; margin-top: 30px; background-color: #4CAF50; color: white; border: none; border-radius: 5px; float: right;'>Add User</button>";
              } else {
            echo "No users found.";
            // Add buttons for Add Admin and Add User
            echo "<button onclick=\"window.location.href='SignUp-index.php?role=admin';\" style='display: inline-block; padding: 10px 20px; margin-top: 30px; background-color: #4CAF50; color: white; border: none; border-radius: 5px; float: left;'>Add Admin</button>";
            echo "<button onclick=\"window.location.href='SignUp-index.php?role=user';\" style='display: inline-block; padding: 10px 20px; margin-top: 30px; background-color: #4CAF50; color: white; border: none; border-radius: 5px; float: right;'>Add User</button>";
             }
    } elseif ($action === 'view_user') {
        // View user details by ID
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
                echo "<p>Gender: {$userData['gender']}</p>";
                echo "<p>Age: {$userData['age']}</p>";
                echo "<p>Address: {$userData['address']}</p>";
                echo "<p>Subscription: {$userData['subscription']}</p>";
            } else {
                echo "User not found.";
            }
        } else {
            echo "No user ID provided.";
        }
    } elseif ($action === 'edit_user') {
        // Edit user details (form and process)
        $userId = $_GET['id'] ?? null;
        if ($userId) {
            $userData = $user->getUserById($userId);
            if ($userData) {
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    // Update user
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
                    // Display edit form
                    echo "<h3>Edit User</h3>";
                    echo "<form method='POST'>
                            <label>Full Name:</label>
                            <input type='text' name='fullname' value='{$userData['fullname']}' required><br>
                            <label>Username:</label>
                            <input type='text' name='username' value='{$userData['username']}' required><br>
                            <label>Email:</label>
                            <input type='email' name='useremail' value='{$userData['useremail']}' required><br>
                            <label>Phone:</label>
                            <input type='text' name='userphone' value='{$userData['userphone']}' required><br>
                            <label>Role:</label>
                            <input type='text' name='role' value='{$userData['role']}' required><br>
                            <label>Gender:</label>
                            <input type='text' name='gender' value='{$userData['gender']}' required><br>
                            <label>Age:</label>
                            <input type='number' name='age' value='{$userData['age']}' required><br>
                            <label>Address:</label>
                            <input type='text' name='address' value='{$userData['address']}' required><br>
                            <label>Subscription:</label>
                            <input type='text' name='subscription' value='{$userData['subscription']}' required><br>
                            <button type='submit'>Update</button>
                          </form>";
                }
            } else {
                echo "User not found.";
            }
        } else {
            echo "No user ID provided.";
        }
    } elseif ($action === 'delete_user') {
        // Delete user
        $userId = $_GET['id'] ?? null;
        if ($userId) {
            echo $user->deleteUser($userId);
        } else {
            echo "No user ID provided.";
        }
    }

    // Product handling
    $product = new Product($conn);

    if ($action === 'view_all_products') {
        // Fetch and display all products
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
            foreach ($products as $u) {
                echo "<tr>
                        <td>{$u['id']}</td>
                        <td>{$u['productname']}</td>
                        <td>{$u['price']}</td>
                        <td>{$u['quantity']}</td>
                        <td>
                            <a href='admin-index.php?action=view_product&id={$u['id']}'>View</a> |
                            <a href='admin-index.php?action=edit_product&id={$u['id']}'>Edit</a> |
                            <a href='admin-index.php?action=delete_product&id={$u['id']}'>Delete</a>
                        </td>
                    </tr>";
            }
            echo "</table>";
            echo "<a href='admin-index.php?action=add_product' style='display: inline-block; padding: 10px 20px; margin-top: 30px; background-color: #4CAF50; color: white; text-decoration: none; border-radius: 5px;'>Add Product</a>";
        } else {
            echo "No products found.";
        }
    } elseif ($action === 'add_product') {
        // Add product details
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Add product to the database
            $productname = $_POST['productname'];
            $price = $_POST['price'];
            $quantity = $_POST['quantity'];
    
            // Call the addProduct method from the Product class
            $result = $product->addProduct($productname, $price, $quantity);
            echo $result;
        }
    
    else {
            // Display the add product form
            echo "<h3>Add New Product</h3>";
            echo "<form method='POST'>
                    <label>Product Name:</label>
                    <input type='text' name='productname' required><br>
                    <label>Price:</label>
                    <input type='number' step='0.01' name='price' required><br>
                    <label>Quantity:</label>
                    <input type='number' name='quantity' required><br>
                    <button type='submit'>Add Product</button>
                  </form>";
        }
    } elseif ($action === 'view_product') {
        // View product details by ID
        $productId = $_GET['id'] ?? null;
        if ($productId) {
            $productData = $product->getProductById($productId);
            if ($productData) {
                echo "<h3>Product Details</h3>";
                echo "<p>ID: {$productData['id']}</p>";
                echo "<p>Product Name: {$productData['productname']}</p>";
                echo "<p>Price: {$productData['price']}</p>";
                echo "<p>Quantity: {$productData['quantity']}</p>";
            } else {
                echo "Product not found.";
            }
        } else {
            echo "No product ID provided.";
        }
    } elseif ($action === 'edit_product') {
        // Edit product details (form and process)
        $productId = $_GET['id'] ?? null;
        if ($productId) {
            $productData = $product->getProductById($productId);
            if ($productData) {
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    // Update product
                    $productname = $_POST['productname'];
                    $price = $_POST['price'];
                    $result = $product->updateProduct(
                        $productId,
                        $productname,
                        $price,
                        quantity: $quantity
                    );
                    echo $result;
                } else {
                    // Display edit form
                    echo "<h3>Edit Product</h3>";
                    echo "<form method='POST'>
                            <label>Product Name:</label>
                            <input type='text' name='productname' value='{$productData['productname']}' required><br>
                            <label>Username:</label>
                            <input type='number' name='price' value='{$productData['price']}' required><br>
                            <input type='number' name='quantity' value='{$productData['quantity']}' required><br>
                            <button type='submit'>Update</button>
                          </form>";
                }
            } else {
                echo "Product not found.";
            }
        } else {
            echo "No product ID provided.";
        }
    } elseif ($action === 'delete_product') {
        // Delete product
        $productId = $_GET['id'] ?? null;
        if ($productId) {
            echo $product->deleteProduct($productId);
        } else {
            echo "No product ID provided.";
        }
    }

    $conn->close();
    ?>
</body>
</html>  