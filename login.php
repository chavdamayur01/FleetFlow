<?php
session_start();
include("db/db.php");

$error = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    // Prepare statement
    $stmt = $conn->prepare("SELECT * FROM users WHERE email=? AND role=?");
    $stmt->bind_param("ss", $email, $role);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows == 1){

        $user = $result->fetch_assoc();

        if(password_verify($password, $user['password'])){

            session_regenerate_id(true);

            $_SESSION['logged_in'] = true;
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['name'] = $user['name'];
            $_SESSION['role'] = $user['role'];

            // Role-based redirection
            if($user['role'] == 'admin'){
                header("Location: dashboard.php");
                exit();
            } elseif($user['role'] == 'dispatcher'){
                header("Location: dispatcher_dashbord.php");
                exit();
            } else {
                $error = "Invalid Role!";
            }

        } else {
            $error = "Wrong Password!";
        }

    } else {
        $error = "User Not Found For Selected Role!";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>FleetFlow Login</title>
    <link rel="stylesheet" href="assets/style.css">
</head>

<body>

<div class="login-container">
    <div class="login-box">

        <h2>FleetFlow</h2>
        <p>Fleet & Logistics System</p>

        <?php if($error!=""){ ?>
            <div class="error"><?php echo $error; ?></div>
        <?php } ?>

        <form method="POST">

            <input type="email" name="email" placeholder="Enter Email" required>

            <input type="password" name="password" placeholder="Enter Password" required>

            <!-- ROLE SELECT -->
            <select name="role" required>
                <option value="">Select Role</option>
                <option value="admin">Admin</option>
                <option value="dispatcher">Dispatcher</option>
            </select>

            <button type="submit">Login</button>

            <div class="forgot">
                <a href="forgot_password.php">Forgot Password?</a>
            </div>

        </form>

    </div>
</div>

</body>
</html>