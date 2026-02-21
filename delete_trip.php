<?php
session_start();
include("db/db.php");

// Role check
if(!isset($_SESSION['logged_in']) || $_SESSION['role'] != 'dispatcher'){
    header("Location: dashboard.php");
    exit();
}

$error = "";
$success = "";

// Handle delete action
if(isset($_GET['delete_id'])){
    $trip_id = (int)$_GET['delete_id'];

    // Delete trip
    $stmt = $conn->prepare("DELETE FROM trips WHERE trip_id = ?");
    $stmt->bind_param("i", $trip_id);
    if($stmt->execute()){
        $success = "Trip deleted successfully!";
    } else {
        $error = "Error deleting trip: " . $stmt->error;
    }
}

// Fetch active trips
$trips_result = mysqli_query($conn, "SELECT * FROM trips WHERE status='active' ORDER BY trip_id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Delete Trip</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
<style>
body {font-family:'Roboto',sans-serif;background:#f7f9fc;margin:0;padding:0;}
.top-header {background:#0d6efd;color:#fff;padding:15px 30px;display:flex;justify-content:space-between;align-items:center;}
.top-header .logo{font-weight:700;font-size:1.4em;}
.top-header .user-info span{font-weight:500;}
.logout-btn {background:#ffc107;color:#000;padding:6px 12px;text-decoration:none;border-radius:5px;margin-left:10px;}
.table-container {max-width:1000px;margin:30px auto;background:#fff;padding:20px;border-radius:12px;box-shadow:0 5px 15px rgba(0,0,0,0.1);}
table {width:100%;border-collapse:collapse;}
th,td {padding:12px;border:1px solid #ddd;text-align:center;}
th {background:#0d6efd;color:#fff;}
.btn {padding:6px 12px;border:none;border-radius:5px;cursor:pointer;}
.btn.delete {background:#dc3545;color:#fff;}
.error-msg {color:red;text-align:center;margin-bottom:10px;}
.success-msg {color:green;text-align:center;margin-bottom:10px;}
</style>
</head>
<body>

<header class="top-header">
<div class="logo">Fleet System</div>
<div class="user-info">
Welcome Dispatcher | <span><?php echo $_SESSION['name']; ?></span>
<a href="logout.php" class="logout-btn">Logout</a>
</div>
</header>

<div class="table-container">
<h2>Active Trips</h2>
<?php if($error) echo "<p class='error-msg'>$error</p>"; ?>
<?php if($success) echo "<p class='success-msg'>$success</p>"; ?>

<table>
<thead>
<tr>
<th>ID</th>
<th>Start</th>
<th>End</th>
<th>Driver ID</th>
<th>Vehicle ID</th>
<th>Total KG</th>
<th>Start Date</th>
<th>End Date</th>
<th>Action</th>
</tr>
</thead>
<tbody>
<?php while($trip = mysqli_fetch_assoc($trips_result)): ?>
<tr>
<td><?php echo $trip['trip_id']; ?></td>
<td><?php echo $trip['start_point']; ?></td>
<td><?php echo $trip['end_point']; ?></td>
<td><?php echo $trip['driver_id']; ?></td>
<td><?php echo $trip['vehicle_id']; ?></td>
<td><?php echo $trip['total_kg']; ?></td>
<td><?php echo $trip['send_date']; ?></td>
<td><?php echo $trip['end_date']; ?></td>
<td>
    <a href="?delete_id=<?php echo $trip['trip_id']; ?>" class="btn delete" onclick="return confirm('Are you sure you want to delete this trip?');">Delete</a>
</td>
</tr>
<?php endwhile; ?>
</tbody>
</table>
</div>

</body>
</html>