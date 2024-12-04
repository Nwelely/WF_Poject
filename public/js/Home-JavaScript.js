function openMembership() {
  window.open('/membership', '_self'); 
}
document.getElementById('membershipCard').addEventListener('click', openMembership);

function openCoaches() {
  window.open('/coaches', '_self'); 
}
document.getElementById('coachescard').addEventListener('click', openCoaches);

function openShop() {
  window.open('/shop', '_self'); 
}
document.getElementById('shopcard').addEventListener('click', openShop);

function togglePopup() {
  var popup = document.getElementById("popupContainer");
  popup.style.display = (popup.style.display === "none" || popup.style.display === "") ? "block" : "none";
}

document.getElementById("calculateButton").addEventListener("click", function() {
  var weight = parseFloat(document.getElementById("weight").value);
  var height = parseFloat(document.getElementById("height").value);
  var age = parseInt(document.getElementById("age").value);
  var gender = document.getElementById("gender").value;

  var bmr;
  if (gender === "male") {
    bmr = (10 * weight) + (6.25 * height) - (5 * age) + 5;
  } else {
    bmr = (10 * weight) + (6.25 * height) - (5 * age) - 161;
  }

  var resultElement = document.getElementById("result");
  var resultLabelContainer = document.getElementById("result_container");
  var resultLabelElement = document.getElementById("result_label");
  resultLabelElement.innerHTML = "Calories Result: " + bmr.toFixed(0);
  resultLabelContainer.style.display = "block";
});


function toggleDarkMode() {
  const body = document.body;
  const isDarkMode = body.classList.contains('dark-mode');

  if (isDarkMode) {
    body.classList.remove('dark-mode');
    localStorage.setItem('darkModeEnabled', 'false'); // Store light mode preference
    document.querySelector('.darkmode-button').textContent = 'Dark Mode'; // Update button text
  } else {
    body.classList.add('dark-mode');
    localStorage.setItem('darkModeEnabled', 'true'); // Store dark mode preference
    document.querySelector('.darkmode-button').textContent = 'Light Mode'; // Update button text
  }
}

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