document.addEventListener("DOMContentLoaded", function() {
    const pushCard = document.getElementById("push");
    const pullCard = document.getElementById("pull");
    const legsCard = document.getElementById("legs");

    pushCard.addEventListener("click", function() {
        window.location.href = "/user/push-workout";
    });

    pullCard.addEventListener("click", function() {
        window.location.href = "/user/pull-workout";
    });

    legsCard.addEventListener("click", function() {
        window.location.href = "/user/legs-workout";
    });
});







// Check and apply stored dark mode preference on page load
document.addEventListener('DOMContentLoaded', function () {
    const isDarkMode = localStorage.getItem('darkModeEnabled') === 'true';
    const darkModeButton = document.querySelector('.darkmode-button');
    
    if (isDarkMode) {
      document.body.classList.add('dark-mode');
      darkModeButton.textContent = 'Light Mode';
    } else {
      document.body.classList.remove('dark-mode');
      darkModeButton.textContent = 'Dark Mode';
    }
  });