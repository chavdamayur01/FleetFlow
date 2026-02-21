<?php
include("db/db.php");

$pass = password_hash("admin123", PASSWORD_DEFAULT);

$sql = "INSERT INTO users (name,email,password,role)
VALUES ('System Admin','admin@fleetflow.com','$pass','admin')";

if($conn->query($sql)){
    echo "Admin Created Successfully";
}else{
    echo "Error: " . $conn->error;
}
?>