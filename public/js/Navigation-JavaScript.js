document.addEventListener('DOMContentLoaded', function () {
  var notificationBar = document.getElementById('notification-bar');
  if (notificationBar) {
    var notificationContent = notificationBar.querySelector('.notification-content');
    setTimeout(function () {
      notificationBar.classList.add('show');

      // Set the height of the notification bar to match the height of the content
      notificationBar.style.height = notificationContent.scrollHeight + 'px';

      setTimeout(function () {
        notificationBar.classList.remove('show');
        
        // Reset the height after the notification is hidden
        notificationBar.style.height = '0';
      }, 2000); 
    }, 400); 
  }
});







// Check and apply stored dark mode preference on page load
document.addEventListener('DOMContentLoaded', function () {
  const isDarkMode = localStorage.getItem('darkModeEnabled') === 'true';
  const darkModeButton = document.querySelector('.darkmode-button');
  
  if (isDarkMode) {
    document.body.classList.add('dark-mode');
    darkModeButton.textContent = 'Light Mode';
  } else {
    // document.body.classList.remove('dark-mode');
    // darkModeButton.textContent = 'Dark Mode';
  }
});