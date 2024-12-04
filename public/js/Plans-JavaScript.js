document.addEventListener("DOMContentLoaded", function () {
  var subscribedPlan = null; 

  function openPaymentPage(plan, button) {
      var pageURL;
      switch(plan) {
          case 'free':
              pageURL = "/free-plan";
              break;
          case 'standard':
              pageURL = "/auth/payment";
              break;
          case 'premium':
              pageURL = "/coaches";
              break;
          default:
              break;
      }
      window.open(pageURL, "_self");
      button.textContent = "View Your Plan";
      subscribedPlan = plan;
  }

  function checkPage() {
      if (subscribedPlan) {
          var currentPage = window.location.pathname;
          var targetPage;
          switch (subscribedPlan) {
              case 'free':
                  targetPage = "/free-plan";
                  break;
              case 'standard':
                  targetPage = "/auth/payment";
                  break;
              case 'premium':
                  targetPage = "/coaches";
                  break;
              default:
                  break;
          }
          if (currentPage.includes(targetPage)) {
              var buttonId = "subscribebtn" + subscribedPlan.charAt(1);
              var button = document.getElementById(buttonId);
              if (button) {
                  button.textContent = "View Your Plan";
              }
          }
      }
  }

  checkPage();

  function clickHandler() {
      var plan;
      if (this.id === "subscribebtn1") {
          plan = "free";
      } else if (this.id === "subscribebtn2") {
          plan = "standard";
      } else if (this.id === "subscribebtn3") {
          plan = "premium";
      }
      openPaymentPage(plan, this);
  }

  document.getElementById("subscribebtn1").addEventListener("click", clickHandler);
  document.getElementById("subscribebtn2").addEventListener("click", clickHandler);
  document.getElementById("subscribebtn3").addEventListener("click", clickHandler);
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