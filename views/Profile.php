<?php
session_start();

// Redirect if user is not logged in
if (!isset($_SESSION['user']) || empty($_SESSION['user'])) {
    header("Location: /WF_Poject/views/login-index.php");
    exit();
}

$user = $_SESSION['user'];

// Determine the profile image path
$imagePath = isset($user['img']) && !empty($user['img']) && file_exists('../uploads/' . $user['img'])
    ? '../uploads/' . $user['img']
    : '../public/images/default-profile.jpg';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>My Profile</title>
  <link rel="stylesheet" href="../public/css/Profile-Styles.css">
</head>
<body>
  <!-- Include Navigation -->
  <?php include('partials/Navigation-Index.php'); ?>

  <h1 class="profile-heading">My Profile</h1>

  <div class="profile-container" data-user-id="<?php echo htmlspecialchars($user['id']); ?>">
    <!-- Profile Image -->
    <div class="profile-image-container">
      <img src="<?php echo htmlspecialchars($imagePath); ?>" alt="Profile Picture" class="profile-image" id="profileImage">
    </div>

    <!-- User Details -->
    <div class="profile-details">
      <p><strong>Name:</strong> <span><?php echo htmlspecialchars($user['fullname']); ?></span></p>
      <p><strong>Email:</strong> <span><?php echo htmlspecialchars($user['useremail']); ?></span></p>
      <p><strong>Address:</strong> <span><?php echo htmlspecialchars($user['address'] ?? 'N/A'); ?></span></p>
      <p><strong>Gender:</strong> <span><?php echo htmlspecialchars($user['gender'] ?? 'N/A'); ?></span></p>
      <p><strong>Age:</strong> <span><?php echo htmlspecialchars($user['age'] ?? 'N/A'); ?></span></p>
      <p><strong>Phone Number:</strong> <span><?php echo htmlspecialchars($user['userphone'] ?? 'N/A'); ?></span></p>

      <!-- Visa Information -->
      <?php if (!empty($user['visa'])): ?>
        <h2>Visa Information</h2>
        <select id="visaSelect" onchange="showVisaDetails()">
          <option value="">Select Visa</option>
          <?php foreach ($user['visa'] as $index => $visa): ?>
            <option value="<?php echo $index; ?>">Visa <?php echo $index + 1; ?></option>
          <?php endforeach; ?>
        </select>

        <?php foreach ($user['visa'] as $index => $visa): ?>
          <div class="visa-details hidden" id="visaDetails<?php echo $index; ?>">
            <p><strong>Cardholder Name:</strong> <?php echo htmlspecialchars($visa['cardholdername']); ?></p>
            <p><strong>Expire Date:</strong> <?php echo htmlspecialchars($visa['expiredate']); ?></p>
            <p><strong>Card Number:</strong> ************<?php echo htmlspecialchars($visa['last4digits']); ?></p>
            <button class="remove-visa-button">Remove Visa</button>
          </div>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>
  </div>

  <!-- Action Buttons -->
  <div class="button-group">
    <button id="workoutsButton">My Workouts</button>
    <button id="mealsButton">My Meals</button>
    <button id="editProfileButton">Edit My Profile</button>
    <button id="deleteAccountButton" class="hidden" style="background-color: red;">Delete Account</button>
  </div>

  <script src="../public/js/Profile-JavaScript.js"></script>
</body>
</html>
