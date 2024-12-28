<!DOCTYPE html>
<html lang="<?php echo isset($lang) ? $lang : 'en'; ?>">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Navigation</title>
  <link rel="stylesheet" href="../../public/css/Navigation-Style.css">
</head>
<body>
  <div class="header-nav-container">
    <header class="logo-container">
      <h1>WEB-FIT</h1>
    </header>
    <nav class="nav-container">
      <!-- Static links -->
      <a href="http://localhost/WF_Poject/app/views/index.php">Home</a>
      <a href="http://localhost/WF_Poject/app/views/AboutUs-index.php">About Us</a>
      <a href="http://localhost/WF_Poject/app/views/shop.php">Shop</a>
      <a href="http://localhost/WF_Poject/app/views/contact.php">Contact</a>
      <a href="http://localhost/WF_Poject/app/views/plans-index.php">Join Us</a>

      <?php 
      // If user is logged in and role is admin, hide login and signup links
      if (isset($_SESSION['user'])) { 
        if ($_SESSION['user']['role'] === 'admin') { ?>
          <!-- Admin Dashboard link, no profile for admin -->
          <a id="profile-link" href="http://localhost/WF_Poject/app/views/Profile.php">My Profile</a>
          <a id="admin-link" href="http://localhost/WF_Poject/app/views/Admin-index.php">Admin Dashboard</a>
          <a id="logout-link" href="http://localhost/WF_Poject/app/views/logout.php">Logout</a>
        <?php } else { ?>
          <!-- If user is a regular user -->
          <a id="profile-link" href="http://localhost/WF_Poject/app/views/Profile.php">My Profile</a>
          <a id="logout-link" href="http://localhost/WF_Poject/app/views/logout.php">Logout</a>
        <?php } ?>
      <?php } else { ?>
        <!-- If user is not logged in, show login and signup links -->
        <a id="login-link" href="http://localhost/WF_Poject/app/views/Login-index.php">Login</a>
        <a id="signup-link" href="http://localhost/WF_Poject/app/views/SignUp-index.php">Signup</a>
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

  <script src="../../public/js/Navigation-JavaScript.js"></script>
</body>
</html>
