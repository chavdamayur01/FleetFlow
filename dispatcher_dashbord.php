<?php
session_start();
include("db/db.php");

// Role-based access: Only dispatcher
if(!isset($_SESSION['logged_in']) || $_SESSION['role'] != 'dispatcher'){
    header("Location: dashboard.php"); // redirect non-dispatcher users
    exit();
}

// Fetch trips with driver and vehicle info
$trips_sql = "
SELECT t.*, d.name AS driver_name, v.vehicle_model, v.number_plate 
FROM trips t
LEFT JOIN drivers d ON t.driver_id = d.driver_id
LEFT JOIN vehicles v ON t.vehicle_id = v.id
ORDER BY t.trip_id DESC
";
$trips_result = mysqli_query($conn, $trips_sql);

// Dashboard counts
$active_trips = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as cnt FROM trips WHERE status='active'"))['cnt'];
$free_vehicles = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as cnt FROM vehicles WHERE status='active'"))['cnt'];
$free_drivers = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as cnt FROM drivers WHERE status='active'"))['cnt'];
$pending_trips = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as cnt FROM trips WHERE status='future'"))['cnt'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Dispatcher Dashboard</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
<style>
body { font-family:'Roboto',sans-serif; background:#f7f9fc; margin:0; padding:0; }
.top-header { background:#0d6efd; color:#fff; padding:15px 30px; display:flex; justify-content:space-between; align-items:center; }
.top-header .logo { font-weight:700; font-size:1.4em; }
.top-header .user-info span { font-weight:500; }
.logout-btn { background:#ffc107; color:#000; padding:6px 12px; text-decoration:none; border-radius:5px; margin-left:10px; }
.dashboard-cards { display:flex; justify-content:center; gap:20px; margin:30px 0; flex-wrap:wrap; }
.dashboard-cards .card { background:#fff; padding:20px 30px; border-radius:12px; box-shadow:0 5px 15px rgba(0,0,0,0.1); text-align:center; flex:1; min-width:180px; }
.dashboard-cards h3 { margin:0 0 10px; color:#0d6efd; }
.dashboard-cards p { font-size:1.5em; font-weight:500; }
.action-buttons { text-align:center; margin-bottom:20px; }
.action-buttons .btn { padding:12px 20px; margin:0 5px; border:none; border-radius:8px; cursor:pointer; color:#fff; }
.btn.primary { background:#0d6efd; }
.btn.danger { background:#dc3545; }
.btn.warning { background:#ffc107; color:#000; }
.table-section { max-width:1200px; margin:0 auto 50px; overflow-x:auto; }
table { width:100%; border-collapse:collapse; background:#fff; border-radius:10px; overflow:hidden; box-shadow:0 5px 15px rgba(0,0,0,0.05); }
th, td { padding:12px 15px; text-align:center; border-bottom:1px solid #eee; }
th { background:#0d6efd; color:#fff; }
.view-btn { background:#198754; color:#fff; padding:6px 12px; border:none; border-radius:5px; cursor:pointer; }

/* Popup */
.popup { display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); justify-content:center; align-items:center; z-index:1000; }
.popup .popup-content { background:#fff; padding:20px 30px; border-radius:10px; max-width:600px; width:100%; position:relative; max-height:90vh; overflow-y:auto; box-shadow:0 8px 25px rgba(0,0,0,0.2);}
.popup .close { position:absolute; top:10px; right:15px; cursor:pointer; font-size:24px; font-weight:bold; }
.popup h3 { margin-top:0; color:#0d6efd; text-align:center; }
.popup .trip-detail { margin:10px 0; }
.trip-detail label { font-weight:500; display:block; margin-bottom:5px; }
.trip-detail span { display:block; margin-bottom:10px; }
#print-btn { background:#0d6efd; color:#fff; border:none; padding:10px 15px; border-radius:6px; cursor:pointer; margin-top:15px; width:100%; font-size:1em; }
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

<!-- DASHBOARD CARDS -->
<section class="dashboard-cards">
    <div class="card"><h3>Active Trips</h3><p><?php echo $active_trips; ?></p></div>
    <div class="card"><h3>Free Vehicles</h3><p><?php echo $free_vehicles; ?></p></div>
    <div class="card"><h3>Free Drivers</h3><p><?php echo $free_drivers; ?></p></div>
    <div class="card"><h3>Pending Trips</h3><p><?php echo $pending_trips; ?></p></div>
</section>

<!-- ACTION BUTTONS -->
<section class="action-buttons">
    <a href="trip_form.php"><button class="btn primary">➕ Create Trip</button></a>
    <a href="delete_trip.php"><button class="btn danger">🗑 Delete Trip</button></a>
    <a href="competel_trip.php"><button class="btn warning">💰 Over Trips</button></a>
</section>

<!-- TABLE -->
<section class="table-section">
    <table>
        <thead>
            <tr>
                <th>Start</th>
                <th>End</th>
                <th>Driver Name</th>
                <th>Vehicle</th>
                <th>Total Items</th>
                <th>Fuel Expense</th>
                <th>Other Cost</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Total KM</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        <?php while($trip = mysqli_fetch_assoc($trips_result)): ?>
            <tr>
                <td><?php echo $trip['start_point']; ?></td>
                <td><?php echo $trip['end_point']; ?></td>
                <td><?php echo $trip['driver_name']; ?></td>
                <td><?php echo $trip['vehicle_model']." (".$trip['number_plate'].")"; ?></td>
                <td><?php echo $trip['total_items']; ?></td>
                <td>₹<?php echo $trip['fuel_expense']; ?></td>
                <td>₹<?php echo $trip['other_cost']; ?></td>
                <td><?php echo $trip['send_date']; ?></td>
                <td><?php echo $trip['end_date']; ?></td>
                <td><?php echo $trip['total_km']; ?></td>
                <td><?php echo ucfirst($trip['status']); ?></td>
                <td><button class="view-btn" onclick='openPopup(<?php echo json_encode($trip); ?>)'>View</button></td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
</section>

<!-- POPUP -->
<div class="popup" id="tripPopup">
    <div class="popup-content" id="popupContent">
        <span class="close" onclick="closePopup()">&times;</span>
        <h3>Trip Details</h3>

        <!-- Trip Info Grid -->
        <div class="trip-grid">
            <div class="trip-card">
                <h4>Route Info</h4>
                <p><strong>Start Point:</strong> <span id="popup_start"></span></p>
                <p><strong>End Point:</strong> <span id="popup_end"></span></p>
                <p><strong>Total KM:</strong> <span id="popup_km"></span></p>
            </div>

            <div class="trip-card">
                <h4>Driver & Vehicle</h4>
                <p><strong>Driver:</strong> <span id="popup_driver"></span></p>
                <p><strong>Vehicle:</strong> <span id="popup_vehicle"></span></p>
            </div>

            <div class="trip-card">
                <h4>Items & Dates</h4>
                <p><strong>Total Items:</strong> <span id="popup_items"></span></p>
                <p><strong>Start Date:</strong> <span id="popup_send"></span></p>
                <p><strong>End Date:</strong> <span id="popup_enddate"></span></p>
            </div>

            <div class="trip-card expense-card">
                <h4>Expenses</h4>
                <p><strong>Fuel Expense:</strong> <span id="popup_fuel"></span></p>
                <p><strong>Other Cost:</strong> <span id="popup_other"></span></p>
                <p><strong>Description:</strong> <span id="popup_other_desc"></span></p>
                <hr>
                <p><strong>Total Expense:</strong> <span id="popup_total"></span></p>
            </div>

            <div class="trip-card status-card">
                <h4>Status</h4>
                <p id="popup_status"></p>
            </div>
        </div>

        <button id="print-btn" onclick="printTrip()">🖨 Print / Download</button>
    </div>
</div>
<style>
/* Popup layout */
.popup { display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); justify-content:center; align-items:center; z-index:1000; }
.popup-content { background:#fff; padding:20px 30px; border-radius:12px; max-width:700px; width:90%; position:relative; max-height:90vh; overflow-y:auto; box-shadow:0 10px 30px rgba(0,0,0,0.2);}
.popup-content h3 { margin-top:0; color:#0d6efd; text-align:center; font-size:1.6em; margin-bottom:20px; }
.popup .close { position:absolute; top:15px; right:20px; cursor:pointer; font-size:28px; font-weight:bold; }

.trip-grid { display:grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap:20px; margin-bottom:20px; }
.trip-card { background:#f7f9fc; padding:15px 20px; border-radius:10px; box-shadow:0 3px 10px rgba(0,0,0,0.05); }
.trip-card h4 { margin-top:0; color:#0d6efd; font-size:1.1em; margin-bottom:10px; border-bottom:1px solid #ddd; padding-bottom:5px; }
.trip-card p { margin:6px 0; font-size:0.95em; }
.trip-card p strong { color:#333; }

.expense-card { background:#fff4e5; border-left:4px solid #ffa500; }
.status-card { background:#e5f7ff; border-left:4px solid #0d6efd; text-align:center; font-weight:bold; font-size:1.1em; }

#print-btn { background:#0d6efd; color:#fff; border:none; padding:12px 0; border-radius:8px; cursor:pointer; font-size:1em; width:100%; transition:0.3s; }
#print-btn:hover { background:#0b5ed7; }
</style>

<script>
// Open popup
function openPopup(trip){
    document.getElementById('tripPopup').style.display = 'flex';
    document.getElementById('popup_start').innerText = trip.start_point;
    document.getElementById('popup_end').innerText = trip.end_point;
    document.getElementById('popup_driver').innerText = trip.driver_name;
    document.getElementById('popup_vehicle').innerText = trip.vehicle_model + " ("+trip.number_plate+")";
    document.getElementById('popup_items').innerText = trip.total_items;
    document.getElementById('popup_fuel').innerText = "₹" + trip.fuel_expense;
    document.getElementById('popup_other').innerText = "₹" + trip.other_cost;
    document.getElementById('popup_other_desc').innerText = trip.description_other_cost;
    document.getElementById('popup_total').innerText = "₹" + trip.total_expense;
    document.getElementById('popup_send').innerText = trip.send_date;
    document.getElementById('popup_enddate').innerText = trip.end_date;
    document.getElementById('popup_km').innerText = trip.total_km;
    document.getElementById('popup_status').innerText = trip.status.charAt(0).toUpperCase() + trip.status.slice(1);
}

// Close popup
function closePopup(){
    document.getElementById('tripPopup').style.display = 'none';
}

// Print / download trip info
function printTrip(){
    const printContents = document.getElementById('popupContent').innerHTML;
    const originalContents = document.body.innerHTML;
    document.body.innerHTML = printContents;
    window.print();
    document.body.innerHTML = originalContents;
    location.reload();
}
</script>

</body>
</html>