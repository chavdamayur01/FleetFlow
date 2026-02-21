<?php
// Database configuration
$servername = "127.0.0.1";   // localhost
$username   = "root";        // default XAMPP user
$password   = "";            // default blank password
$database   = "first_database"; // <-- ahiya tamaru DB name mukvu
$port       = "3307";        // IMPORTANT: apde port change karyo chhe

// Create connection
$conn = mysqli_connect($servername, $username, $password, $database, $port);

// Check connection
if (!$conn) {
    die("Connection Failed: " . mysqli_connect_error());
}
else{
    echo "finaly connect your database";
}

// Optional success message (testing mate)
// echo "Database Connected Successfully!";
?>