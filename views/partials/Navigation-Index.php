<!DOCTYPE html>
<html lang="<?php echo $lang; ?>">
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
      <a href="/WF_Poject/views/index.php">Home</a>
      <a href="/WF_Poject/views/about-index.php">About Us</a>
      <a href="/WF_Poject/views/shop.php">Shop</a>
      <a href="/WF_Poject/views/Contact-Form-index.php">Contact</a>
      <a href="/WF_Poject/views/plans-index.php">Join Us</a>
      
      <?php if (isset($user) && isset($user['username'])) { ?>
        <?php if ($currentPage === 'profile' || $currentPage === 'admin') { ?>
          <a id="login-link" href="/auth/logout">Logout</a>
        <?php } else { ?>
          <?php if ($user['role'] === 'admin') { ?>
            <a id="login-link" href="/auth/admin">Admin Profile</a>
          <?php } else { ?>
            <a id="login-link" href="/user/profile">My Profile</a>
          <?php } ?>
        <?php } ?>
      <?php } else { ?>
        <a id="login-link" href="/WF_Poject/views/login-index.php">Login</a>
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
