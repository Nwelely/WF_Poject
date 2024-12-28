<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Nutrition, Gym, and Supplements</title>
  <link rel="stylesheet" href="../../public/css/About-Style.css">
</head>

<body>
  <?php include('partials/Navigation-Index.php'); ?>

  <div class="about-section">
    <h1 id="header">About Us</h1>
    <h2 id="about_team">
      We at WEB-FIT are passionate about guiding you on your journey to
      optimal health and fitness. Our tailored workout plans are designed to
      challenge and inspire you, ensuring progress and results every step of
      the way. Complementing our dedication to workouts, we offer carefully
      curated nutrient supplements, selected to support your body's needs and
      enhance performance. Behind every program and supplement recommendation
      is a team of experienced professionals, committed to your success. With
      expertise ranging from fitness training to nutrition, our team is here
      to provide personalized guidance and unwavering support, empowering you
      to reach your goals and live your best life.
    </h2>
  </div>

  <h1 class="title">Our Team</h1>
  <div class="card-container">
    <div class="card">
      <img src="../../public/uploads/joe.jfif" alt="James" class="card-image">
      <div class="container">
        <h2>Youssef Hussien</h2>
        <p>
          Having secured the prestigious title of Mr. Olympia twice, I exemplify dedication and perseverance in both
          bodybuilding and programming realms. As a seasoned coder, I navigate complex algorithms while sculpting my
          physique to perfection. Embracing holistic wellness, I am a fervent advocate of balanced nutrition, embodying
          the essence of a 'food athlete' in pursuit of peak performance.
        </p>
        <p>youssef@gmail.com</p>
      </div>
    </div>

    <div class="card">
      <img src="../../public/uploads/nwelely.jfif" alt="Nour El Welely" class="card-image">
      <div class="container">
        <h2>Nour El Welely</h2>
        <p>
          Balancing athleticism with hacking finesse, I thrive in both physical and digital domains. Whether on the
          field or behind a screen, I excel in challenges that demand both strength and intellect. With a passion for
          sports and a knack for hacking, I navigate seamlessly between these worlds, pushing boundaries in both realms.
        </p>
        <p>nourwelely@gmail.com</p>
      </div>
    </div>

    <div class="card">
      <img src="../../public/uploads/nagy.jfif" alt="Yassin Ehab" class="card-image">
      <div class="container">
        <h2>Omar Nagy</h2>
        <p>
          From conquering mountains to mastering melodies, I embrace a diverse range of passions. Whether scaling peaks
          or strumming chords, I find joy in the pursuit of new experiences. With a heart for adventure and a soul for
          creativity, I embody a life rich in exploration and expression, continually seeking inspiration from the world
          around me.
        </p>
        <p>yassin@gamil.com</p>
      </div>
    </div>

    <div class="card">
      <img src="../../public/uploads/srougy.jfif" alt="Mohamed" class="card-image">
      <div class="container">
        <h2>Mohamed Hesham</h2>
        <p>
          Transforming from a humble nerd to a celebrated legend, my journey is a testament to the power of persistence
          and passion. From coding in solitude to achieving greatness, I've proven that even the unlikeliest of paths
          can lead to remarkable success.
        </p>
        <p>Mohamed@gmail.com</p>
      </div>
    </div>
  </div>

  <div class="card">
    <img src="../../public/uploads/yassin.jfif" alt="Yassin" class="card-image">
    <div class="container">
      <h2>Yassin Ehab </h2>
      <p>
        Balancing athleticism with hacking finesse, I thrive in both physical and digital domains. Whether on the
        field or behind a screen, I excel in challenges that demand both strength and intellect. With a passion for
        sports and a knack for hacking, I navigate seamlessly between these worlds, pushing boundaries in both realms.
      </p>
      <p>yassin@gmail.com</p>
    </div>
  </div>

  <p><a href="contact.php" class="contact-button">Contact Us</a></p>

  <script src="/js/About-JavaScript.js"></script>
</body>

</html>
