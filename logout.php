<?php
// Start the session
session_start();

// Destroy all session data
$_SESSION = array();
session_destroy();

// Redirect user to login page
header("Location: login.php");
exit();
?>