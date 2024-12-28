<?php
require_once '../Controllers/UserProfileController.php';

// Redirect if user is not logged in
if (!isset($_SESSION['user']) || empty($_SESSION['user'])) {
    header("Location: /WF_Project/views/login-index.php");
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
  <link rel="stylesheet" href="../../public/css/Profile-Styles.css">
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
      <form id="editProfileForm" action="../Controllers/UserProfileController.php" method="POST">
        <!-- Name -->
        <p><strong>Name:</strong> 
          <span id="displayName"><?php echo htmlspecialchars($user['fullname']); ?></span>
          <input type="text" name="fullname" id="inputName" value="<?php echo htmlspecialchars($user['fullname']); ?>" class="hidden">
        </p>

        <!-- Email -->
        <p><strong>Email:</strong> 
          <span id="displayEmail"><?php echo htmlspecialchars($user['useremail']); ?></span>
          <input type="email" name="useremail" id="inputEmail" value="<?php echo htmlspecialchars($user['useremail']); ?>" class="hidden">
        </p>

        <!-- Address -->
        <p><strong>Address:</strong> 
          <span id="displayAddress"><?php echo htmlspecialchars($user['address'] ?? 'N/A'); ?></span>
          <input type="text" name="address" id="inputAddress" value="<?php echo htmlspecialchars($user['address'] ?? ''); ?>" class="hidden">
        </p>

        <!-- Gender -->
        <p><strong>Gender:</strong> 
          <span id="displayGender"><?php echo htmlspecialchars($user['gender'] ?? 'N/A'); ?></span>
          <select name="gender" id="inputGender" class="hidden">
            <option value="Male" <?php echo $user['gender'] === 'Male' ? 'selected' : ''; ?>>Male</option>
            <option value="Female" <?php echo $user['gender'] === 'Female' ? 'selected' : ''; ?>>Female</option>
            <option value="Other" <?php echo $user['gender'] === 'Other' ? 'selected' : ''; ?>>Other</option>
          </select>
        </p>

        <!-- Age -->
        <p><strong>Age:</strong> 
          <span id="displayAge"><?php echo htmlspecialchars($user['age'] ?? 'N/A'); ?></span>
          <input type="number" name="age" id="inputAge" value="<?php echo htmlspecialchars($user['age'] ?? ''); ?>" class="hidden">
        </p>

        <!-- Phone Number -->
        <p><strong>Phone Number:</strong> 
          <span id="displayPhone"><?php echo htmlspecialchars($user['userphone'] ?? 'N/A'); ?></span>
          <input type="text" name="userphone" id="inputPhone" value="<?php echo htmlspecialchars($user['userphone'] ?? ''); ?>" class="hidden">
        </p>

        <!-- Save Button -->
        <button type="submit" id="saveProfileButton" class="hidden">Save</button>
      </form>
    </div>
  </div>

  <!-- Action Buttons -->
  <div class="button-group">
    <button id="editProfileButton">Edit My Profile</button>
  </div>

  <script>
    const editButton = document.getElementById("editProfileButton");
    const saveButton = document.getElementById("saveProfileButton");

    const displayElements = document.querySelectorAll("span");
    const inputElements = document.querySelectorAll("input, select");

    editButton.addEventListener("click", () => {
      // Hide display elements and show input fields
      displayElements.forEach(el => el.classList.add("hidden"));
      inputElements.forEach(el => el.classList.remove("hidden"));

      // Show save button
      saveButton.classList.remove("hidden");
    });
  </script>
</body>
</html>
