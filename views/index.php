<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Nutrition, Gym, and Supplements</title>

  <link rel="stylesheet" href="../public/css/Home-Style.css">
</head>

<?php 
session_start(); // Start the session
include '../config/DB.php'; // Include your database connection
?>

<body>
  <?php include('partials/Navigation-Index.php'); ?>

    <section class="background-image">
      <div class="quote">
        <p>Your health is an investment, not an expense.</p>
      </div>
    </section>

    <button class="popup-button" onclick="togglePopup()">Quick Test</button>
    <button class="darkmode-button" onclick="toggleDarkMode()">Dark Mode</button>

    <div class="popup-container" id="popupContainer">
      <div class="left-content">
        <h2 id="quiz_label">Calories Calculator</h2>
        <form id="caloriesForm">
          <label for="weight">Weight (kg):</label><br />
          <input type="number" id="weight" name="weight" required /><br />

          <label for="height">Height (cm):</label><br />
          <input type="number" id="height" name="height" required /><br />

          <label for="age">Age:</label><br />
          <input type="number" id="age" name="age" required /><br />

          <label for="gender">Gender:</label><br />
          <select id="gender" name="gender" required>
            <option value="male">Male</option>
            <option value="female">Female</option>
          </select><br /><br />
          <div class="right-content">
            <div id="result_container" style="display: none">
              <h2 id="result_label">Calories Result</h2>
              <div id="result"></div>
            </div>
          </div>
          <button type="button" id="calculateButton">Calculate BMR</button>
        </form>
      </div>

      <button onclick="togglePopup()" id="close_quick_test_button">X</button>
    </div>

    <section class="cards services" id="services">
      <h2 class="title">Services</h2>
      <div class="content">
        <div class="card" id="coachescard" onclick="redirectToCoachesPage()">
          <div class="icon">
            <img src="../public/images/coachphoto.jpeg" class="coachimage" />
          </div>
          <div class="coachcard">
            <h3>Coaches</h3>
            <p>
              Meet our team of dedicated coaches, ready to personalize your
              fitness journey and guide you to success at WEB-FIT
            </p>
          </div>
        </div>

        <div class="card" id="membershipCard">
          <div class="icon">
            <img src="../public/images/planss.jpeg" class="plansimage" />
          </div>
          <div class="info">
            <h3>Membership Plans</h3>
            <p>
              Offer individuals comprehensive support and guidance to achieve
              their fitness goals through tailored exercise routines, dietary
              advice, and structured meal plans
            </p>
          </div>
        </div>

        <div class="card" id="shopcard">
          <div class="icon">
            <img src="../public/images/shop.jpeg" class="shopimage" />
          </div>
          <div class="shopcard">
            <h3>Shop Products</h3>
            <p>
              Offer fitness supplements tailored to individual workout
              preferences, providing convenience and quality for achieving
              fitness goals
            </p>
          </div>
        </div>
      </div>
    </section>

    <script src="../public/js/Home-JavaScript.js"></script>
</body>

</html>
