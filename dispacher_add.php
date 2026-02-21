<?php
session_start();
include("db/db.php");

// Only admin can add dispatcher


$message = "";

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Prepare SQL
    $stmt = $conn->prepare("INSERT INTO users (name,email,password,role) VALUES (?,?,?,?)");
    $role = "dispatcher";
    $stmt->bind_param("ssss", $name, $email, $hashed_password, $role);

    if($stmt->execute()){
        $message = "Dispatcher added successfully!";
    } else {
        $message = "Error: ".$conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Dispatcher</title>
    <link rel="stylesheet" href="assets/dispatcher.css">
</head>
<body>
<header class="top-header">
    <div class="logo">Fleet System</div>
    <div class="user-info">
        Welcome Admin | <span><?php echo $_SESSION['name']; ?></span>
        <a href="logout.php" class="logout-btn">Logout</a>
    </div>
</header>

<section style="padding:30px;">
    <h2>Add Dispatcher</h2>
    <?php if($message != "") echo "<p>$message</p>"; ?>
    <form method="POST">
        <input type="text" name="name" placeholder="Dispatcher Name" required><br><br>
        <input type="email" name="email" placeholder="Email" required><br><br>
        <input type="password" name="password" placeholder="Password" required><br><br>
        <button type="submit" class="btn primary">Add Dispatcher</button>
    </form>
</section>
</body>
</html>