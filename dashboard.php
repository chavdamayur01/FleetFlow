<?php
session_start();
include("db/db.php"); // connect to database

// Role check
if(!isset($_SESSION['logged_in']) || $_SESSION['role'] != 'admin'){
    header("Location: dashboard.php");
    exit();
}

// Fetch totals
$totalVehicles = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM vehicles"))['total'];
$totalDrivers = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM drivers"))['total'];

// Total fuel expense for current month
$currentMonth = date('m');
$currentYear = date('Y');
$fuelExpenseRow = mysqli_fetch_assoc(mysqli_query($conn, "
    SELECT SUM(fuel_expense) as total_fuel 
    FROM trips 
    WHERE MONTH(send_date)='$currentMonth' AND YEAR(send_date)='$currentYear'
"));
$totalFuel = $fuelExpenseRow['total_fuel'] ?? 0;

// Active trips count
$activeTrips = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM trips WHERE status='future'"))['total'];

// Fetch active trips list
$activeTripsResult = mysqli_query($conn, "
    SELECT t.trip_id, t.start_point, t.end_point, t.status, v.number_plate, v.vehicle_model, d.name as driver_name
    FROM trips t
    JOIN vehicles v ON t.vehicle_id=v.id
    JOIN drivers d ON t.driver_id=d.driver_id
    WHERE t.status='active'
    ORDER BY t.send_date DESC
");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Dashboard</title>
<link rel="stylesheet" href="assets/dashbord.css">
</head>
<body>

<!-- ===== TOP HEADER ===== -->
<header class="top-header">
    <div class="left">
        <h2>Welcome <?php echo $_SESSION['role']; ?></h2>
    </div>

    <div class="right">
        <span class="admin-name"><?php echo $_SESSION['name']; ?></span>
        <a href="logout.php" class="logout-btn">Logout</a>
    </div>
</header>

<div class="main-container">

<!-- ===== SUMMARY CARDS ===== -->
<section class="summary-cards">

    <div class="card">
        <h3><?php echo $totalVehicles; ?></h3>
        <p>Total Vehicles</p>
    </div>

    <div class="card">
        <h3><?php echo $totalDrivers; ?></h3>
        <p>Total Drivers</p>
    </div>

    <div class="card">
        <h3>₹<?php echo number_format($totalFuel); ?></h3>
        <p>Fuel Expense</p>
    </div>

    <div class="card">
        <h3><?php echo $activeTrips; ?></h3>
        <p>Active Trips</p>
    </div>

</section>

<!-- ===== QUICK ACTIONS ===== -->
<section class="quick-actions">
   <a href="vehicals.php"><button>Add Vehicle</button></a>
    <a href="driver.php"><button>Add Driver</button></a>
   <a href="trip.php"><button>Trip Show</button></a>
   <a href="dispacher_add.php"><button>Add Dispatcher</button></a>      
   <a href="report.php"> <button>View Reports</button></a>
</section>

<!-- ===== ACTIVE TRIPS ===== -->
<section class="panel">
    <h3>Active Trips</h3>

    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>Vehicle No</th>
                    <th>Vehicle Name</th>
                    <th>Driver</th>
                    <th>From</th>
                    <th>To</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
                <?php while($trip = mysqli_fetch_assoc($activeTripsResult)): ?>
                <tr>
                    <td><?php echo $trip['number_plate']; ?></td>
                    <td><?php echo $trip['vehicle_model']; ?></td>
                    <td><?php echo $trip['driver_name']; ?></td>
                    <td><?php echo $trip['start_point']; ?></td>
                    <td><?php echo $trip['end_point']; ?></td>
                    <td><span class="status running"><?php echo ucfirst($trip['status']); ?></span></td>
                    <td><button class="view-btn" onclick="viewTrip(<?php echo $trip['trip_id']; ?>)">View</button></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</section>

<script>
// Here you can add viewTrip(id) JS function to show popup with detailed info dynamically if needed
</script>

</div>
</body>
</html>