// function toggleSignupForm() {
//   const loginContainer = document.getElementById("login-container");
//   const signupContainer = document.getElementById("signup-container");
//   const signupButton = document.querySelector(".signup-button");

//   if (loginContainer.style.display === "none") {
//     loginContainer.style.display = "block";
//     signupContainer.style.display = "none";
//     signupButton.textContent = "Signup";
//   } else {
//     loginContainer.style.display = "none";
//     signupContainer.style.display = "block";
//     signupButton.textContent = "Back to Login";
//   }
// }

// function signUp() {
//   const fullName = document.getElementById("signup-fullname").value.trim();
//   const username = document.getElementById("signup-username").value.trim();
//   const email = document.getElementById("signup-email").value.trim();
//   const age = document.getElementById("signup-age").value.trim();
//   const gender = document.getElementById("signup-gender").value;
//   const password = document.getElementById("signup-password").value;
//   const confirmPassword = document.getElementById("confirm-password").value;

//   if (
//     !fullName ||
//     !username ||
//     !email ||
//     !age ||
//     !gender ||
//     !password ||
//     !confirmPassword
//   ) {
//     alert("Please fill out all the fields.");
//     return;
//   }

//   if (parseInt(age) < 1) {
//     alert("Age must be 1 or greater.");
//     return;
//   }

//   if (/\d/.test(fullName)) {
//     alert("Full name should not contain numbers.");
//     return;
//   }

//   if (email.indexOf("@") === -1 || email.indexOf(".") === -1) {
//     alert("Please enter a valid email address.");
//     return;
//   }

//   if (password !== confirmPassword) {
//     alert("Passwords do not match!");
//     return;
//   }

//   const userData = {
//     fullName: fullName,
//     username: username,
//     email: email,
//     age: age,
//     gender: gender,
//     password: password,
//   };

//   localStorage.setItem(email, JSON.stringify(userData));

//   alert("Signup successful!");
// }

// var isLoggedIn = false;
// var isAdmin = false;

// function login() {
//   const username = document.getElementById("username").value;
//   const password = document.getElementById("password").value;

//   let foundUser = null;
//   for (let i = 0; i < localStorage.length; i++) {
//     const key = localStorage.key(i);
//     const userDataString = localStorage.getItem(key);
//     const userData = JSON.parse(userDataString);
//     if (userData.username === username) {
//       foundUser = userData;
//       break;
//     }
//   }
//   if (username === "admin" && password === "123") {
//     alert("Admin login successful!");
//     isLoggedIn = true; 
//     sessionStorage.setItem("isLoggedIn", "true"); 
//     sessionStorage.setItem("isAdmin", "true"); 
//     return;
//   }
//   if (!foundUser) {
//     alert("Username not found. Please sign up.");
//     return;
//   }

//   if (password === foundUser.password) {
//     alert("Login successful!");
//     isLoggedIn = true; 
//     sessionStorage.setItem("isLoggedIn", "true"); 

//   } else {
//     alert("Incorrect password.");
//     isLoggedIn = false; 
//     sessionStorage.setItem("isLoggedIn", "false"); 
//   }
// }
// const express = require('express');
// const nodemailer = require('nodemailer');
// const app = express();
// const port = 3000;

// app.set('view engine', 'ejs');
// app.use(express.static('public'));
// app.use(express.urlencoded({ extended: true }));

// // Mock user database
// const users = [{ email: 'user@example.com' }];

// app.get('/', (req, res) => {
//   res.render('index');
// });

// app.get('/login', (req, res) => {
//   res.render('login');
// });

// app.post('/auth/login', (req, res) => {
//   // Handle login logic here
//   res.send('Login form submitted');
// });

// app.get('/auth/signup', (req, res) => {
//   res.render('signup');
// });

// app.get('/auth/forgot-password', (req, res) => {
//   res.render('forgot-password');
// });

// app.post('/auth/forgot-password', (req, res) => {
//   const email = req.body.email;
//   const user = users.find(user => user.email === email);

//   if (user) {
//     const resetToken = 'dummy-token'; // Generate a secure token in a real application
//     const resetLink = `http://localhost:${port}/auth/reset-password?token=${resetToken}`;

//     // Send email
//     const transporter = nodemailer.createTransport({
//       service: 'gmail',
//       auth: {
//         user: 'your-email@gmail.com',
//         pass: 'your-email-password'
//       }
//     });

//     const mailOptions = {
//       from: 'your-email@gmail.com',
//       to: email,
//       subject: 'Password Reset',
//       text: `Click the link to reset your password: ${resetLink}`
//     };

//     transporter.sendMail(mailOptions, (error, info) => {
//       if (error) {
//         console.error(error);
//         res.send('Error sending email');
//       } else {
//         console.log('Email sent: ' + info.response);
//         res.send('Password reset link sent to your email');
//       }
//     });
//   } else {
//     res.send('No account found with that email');
//   }
// });

// app.get('/auth/reset-password', (req, res) => {
//   const token = req.query.token;
//   // Verify token and render password reset form
//   res.render('reset-password', { token });
// });

// app.post('/auth/reset-password', (req, res) => {
//   const token = req.body.token;
//   const newPassword = req.body.password;
//   // Verify token and update password in the database
//   res.send('Password has been reset');
// });

// app.listen(port, () => {
//   console.log(`App listening at http://localhost:${port}`);
// });





// document.addEventListener("DOMContentLoaded", function() {
//   const forgotPasswordLink = document.getElementById("forgot-password");
//   const loginContainer = document.getElementById("login-container");
//   const resetPasswordContainer = document.getElementById("reset-password-container");

//   if (forgotPasswordLink) {
//     forgotPasswordLink.addEventListener("click", function(event) {
//       event.preventDefault();
//       loginContainer.style.display = "none";
//       resetPasswordContainer.style.display = "block";
//     });
//   }
// });




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

  document.addEventListener('DOMContentLoaded', function() {
    // Access elements after DOM is fully loaded
    const loginForm = document.getElementById('login-form');
    const loginButton = document.getElementById('login-button');

    // Check if elements exist
    if (loginForm && loginButton) {
        loginButton.textContent = 'Login'; // Example modification
        loginForm.addEventListener('submit', function(event) {
            // Add any client-side validation or behavior here
            console.log('Form is being submitted');
        });
    } else {
        console.warn('Login form or button not found in the DOM.');
    }
});
