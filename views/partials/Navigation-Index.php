<!DOCTYPE html>
<html lang="<?php echo isset($lang) ? $lang : 'en'; ?>">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Navigation</title>
  <link rel="stylesheet" href="../public/css/Navigation-Style.css">
</head>
<body>
  <div class="header-nav-container">
    <header class="logo-container">
      <h1>WEB-FIT</h1>
    </header>
    <nav class="nav-container">
      <!-- Static links -->
      <a href="http://localhost/WF_Poject/views/index.php">Home</a>
      <a href="http://localhost/WF_Poject/views/about-index.php">About Us</a>
      <a href="http://localhost/WF_Poject/views/shop.php">Shop</a>
      <a href="http://localhost/WF_Poject/views/Contact-Form-index.php">Contact</a>
      <a href="http://localhost/WF_Poject/views/plans-index.php">Join Us</a>

      <?php 
      // If user is logged in and role is admin, hide login and signup links
      if (isset($_SESSION['user'])) { 
        if ($_SESSION['user']['role'] === 'admin') { ?>
          <!-- Admin Dashboard link, no profile for admin -->
          <a id="admin-link" href="http://localhost/WF_Poject/views/Admin-index.php">Admin Dashboard</a>
          <a id="logout-link" href="http://localhost/WF_Poject/views/logout.php">Logout</a>
        <?php } else { ?>
          <!-- If user is a regular user -->
          <a id="profile-link" href="http://localhost/WF_Poject/views/Profile.php">My Profile</a>
          <a id="logout-link" href="http://localhost/WF_Poject/views/logout.php">Logout</a>
        <?php } ?>
      <?php } else { ?>
        <!-- If user is not logged in, show login and signup links -->
        <a id="login-link" href="http://localhost/WF_Poject/views/Login-index.php">Login</a>
        <a id="signup-link" href="http://localhost/WF_Poject/views/SignUp-index.php">Signup</a>
      <?php } ?>
    </nav>
  </div>

  <?php if (isset($notification)) { ?>
    <div id="notification-bar" class="notification-bar">
      <div class="notification-content">
        <?php echo $notification; ?>
      </div>
    </div>
  <?php } ?>

  <script src="../public/js/Navigation-JavaScript.js"></script>
</body>
</html>
