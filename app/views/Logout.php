<?php
session_start();

// Clear session data
session_unset();
session_destroy();

// Redirect to the login page
header("Location: /WF_Poject/app/views/login-index.php");
exit;
?>