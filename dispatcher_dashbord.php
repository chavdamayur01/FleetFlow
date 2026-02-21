<?php
session_start();
include("db/db.php");

// Role-based access: Only dispatcher
if(!isset($_SESSION['logged_in']) || $_SESSION['role'] != 'dispatcher'){
    header("Location: dashboard.php"); // redirect non-dispatcher users
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dispatcher Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/dispatcher.css">
</head>
<body>

<!-- TOP HEADER -->
<header class="top-header">
    <div class="logo">Fleet System</div>
    <div class="user-info">
        Welcome Dispatcher | <span><?php echo $_SESSION['name']; ?></span>
        <a href="logout.php" class="logout-btn">Logout</a>
    </div>
</header>

<!-- DASHBOARD CARDS -->
<section class="dashboard-cards">
    <div class="card">
        <h3>Active Trips</h3>
        <p>12</p>
    </div>
    <div class="card">
        <h3>Free Vehicles</h3>
        <p>8</p>
    </div>
    <div class="card">
        <h3>Pending Trips</h3>
        <p>5</p>
    </div>
</section>

<!-- ACTION BUTTONS -->
<section class="action-buttons">
    <button class="btn primary">➕ Create Trip</button>
    <button class="btn danger">🗑 Delete Trip</button>
    <button class="btn warning">💰 Add Expenses</button>
</section>

<!-- FILTER BUTTONS -->
<section class="filters">
    <button class="filter-btn active">All Trips</button>
    <button class="filter-btn">Active Trips</button>
    <button class="filter-btn">Completed Trips</button>
    <button class="filter-btn">Future Trips</button>
</section>

<!-- TABLE -->
<section class="table-section">
    <table>
        <thead>
            <tr>
                <th>Start Point</th>
                <th>End Point</th>
                <th>Driver Name</th>
                <th>Vehicle Name</th>
                <th>Total Items</th>
                <th>Total Fuel</th>
                <th>Total Maintenance</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Total KM</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <!-- STATIC DATA -->
            <tr>
                <td>Ahmedabad</td>
                <td>Surat</td>
                <td>Ramesh Patel</td>
                <td>Tata 407</td>
                <td>Electronics, Furniture</td>
                <td>₹5000</td>
                <td>₹2000</td>
                <td>2026-02-10</td>
                <td>2026-02-12</td>
                <td>250</td>
                <td>Active</td>
                <td><button class="view-btn">View</button></td>
            </tr>
            <tr>
                <td>Vadodara</td>
                <td>Rajkot</td>
                <td>Mahesh Kumar</td>
                <td>Maruti Van</td>
                <td>Clothes</td>
                <td>₹3000</td>
                <td>₹1000</td>
                <td>2026-02-15</td>
                <td>2026-02-16</td>
                <td>180</td>
                <td>Future</td>
                <td><button class="view-btn">View</button></td>
            </tr>
            <tr>
                <td>Surat</td>
                <td>Bhavnagar</td>
                <td>Suresh Shah</td>
                <td>Tata Ace</td>
                <td>Food Items</td>
                <td>₹2000</td>
                <td>₹500</td>
                <td>2026-02-18</td>
                <td>2026-02-18</td>
                <td>120</td>
                <td>Completed</td>
                <td><button class="view-btn">View</button></td>
            </tr>
        </tbody>
    </table>
</section>

</body>
</html>