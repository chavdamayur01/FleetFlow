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

// Handle Over Trip form submission
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['trip_id'])){
    $trip_id = $_POST['trip_id'];
    $fuel_expense = (int)$_POST['fuel_expense'];
    $total_distance = (int)$_POST['total_distance'];
    $other_cost = (int)$_POST['other_cost'];
    $description_other_cost = $_POST['description_other_cost'];
    $total_expense = $fuel_expense + $other_cost;

    // 1. Get the vehicle_id and driver_id for this trip
    $trip_query = $conn->prepare("SELECT vehicle_id, driver_id FROM trips WHERE trip_id=?");
    $trip_query->bind_param("i", $trip_id);
    $trip_query->execute();
    $trip_query->bind_result($vehicle_id, $driver_id);
    $trip_query->fetch();
    $trip_query->close();

    // 2. Update trips table
    $stmt = $conn->prepare("UPDATE trips SET fuel_expense=?, other_cost=?, description_other_cost=?, total_expense=?, total_distance=?, status='completed' WHERE trip_id=?");
    $stmt->bind_param("iiiiii", $fuel_expense, $other_cost, $description_other_cost, $total_expense, $total_distance, $trip_id);

    if($stmt->execute()){
        // 3. Update vehicle status to active
        $conn->query("UPDATE vehicles SET status='active' WHERE id='$vehicle_id'");

        // 4. Update driver status to active
        $conn->query("UPDATE drivers SET status='active' WHERE driver_id='$driver_id'");

        $success = "Trip marked as completed, vehicle and driver set to active!";
    } else {
        $error = "Error updating trip: ".$stmt->error;
    }
}

// Fetch active trips
$trips_result = mysqli_query($conn, "SELECT * FROM trips WHERE status='future' ORDER BY trip_id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Over Trip</title>
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
.btn.over {background:#198754;color:#fff;}
.popup {display:none;position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.5);justify-content:center;align-items:center;}
.popup .popup-content {background:#fff;padding:20px;border-radius:10px;max-width:500px;width:100%;position:relative;}
.popup .close {position:absolute;top:10px;right:10px;cursor:pointer;font-size:20px;font-weight:bold;}
.trip-form input, .trip-form textarea {width:100%;padding:10px;margin:8px 0;border:1px solid #ccc;border-radius:6px;box-sizing:border-box;}
.trip-form label {font-weight:500;}
.trip-form button {background:#0d6efd;color:#fff;padding:10px 15px;border:none;border-radius:6px;cursor:pointer;margin-top:10px;}
.error-msg {color:red;text-align:center;}
.success-msg {color:green;text-align:center;}
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
<td><button class="btn over" onclick="openPopup(<?php echo $trip['trip_id']; ?>)">Over Trip</button></td>
</tr>
<?php endwhile; ?>
</tbody>
</table>
</div>

<!-- Popup Form -->
<div class="popup" id="overPopup">
<div class="popup-content">
<span class="close" onclick="closePopup()">&times;</span>
<h3>Over Trip</h3>
<form method="post" class="trip-form">
<input type="hidden" name="trip_id" id="trip_id">
<label>Fuel Expense</label>
<input type="number" name="fuel_expense" id="fuel_expense" min="0" value="0" required>
<label>Total Distance (km)</label>
<input type="number" name="total_distance" id="total_distance" min="0" value="0" required>
<label>Other Cost</label>
<input type="number" name="other_cost" id="other_cost" min="0" value="0" required>
<label>Description of Other Cost</label>
<textarea name="description_other_cost" id="description_other_cost" rows="3"></textarea>
<label>Total Expense</label>
<input type="number" id="total_expense" value="0" readonly>
<button type="submit">Submit</button>
</form>
</div>
</div>

<script>
// Open popup
function openPopup(tripId){
    document.getElementById('overPopup').style.display='flex';
    document.getElementById('trip_id').value = tripId;
    updateTotal();
}
// Close popup
function closePopup(){
    document.getElementById('overPopup').style.display='none';
}

// Update total expense live
function updateTotal(){
    const fuel = document.getElementById('fuel_expense');
    const other = document.getElementById('other_cost');
    const total = document.getElementById('total_expense');

    function calc(){
        const sum = parseInt(fuel.value||0) + parseInt(other.value||0);
        total.value = sum;
    }

    fuel.addEventListener('input', calc);
    other.addEventListener('input', calc);
    calc();
}
</script>

</body>
</html>