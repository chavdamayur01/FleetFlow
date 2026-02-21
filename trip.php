<?php
session_start();
include("db/db.php"); // Connect to database

// Role check
if(!isset($_SESSION['logged_in']) || $_SESSION['role'] != 'Admin'){
    header("Location: login.php");
    exit();
}

// Fetch trips with driver and vehicle info
$tripsResult = mysqli_query($conn, "
    SELECT t.*, 
           d.name AS driver_name,
           v.vehicle_model,
           v.number_plate
    FROM trips t
    JOIN drivers d ON t.driver_id = d.driver_id
    JOIN vehicles v ON t.vehicle_id = v.id
    ORDER BY t.send_date DESC
");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Trip Management</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="assets/trip.css">
<style>
/* Popup styles */
.popup{
    display:none;
    position:fixed;
    top:0; left:0;
    width:100%; height:100%;
    background: rgba(0,0,0,0.6);
    justify-content:center;
    align-items:center;
    z-index:1000;
}
.popup-content{
    background:#fff;
    padding:20px;
    border-radius:8px;
    width:500px;
    max-width:95%;
    box-shadow:0 5px 15px rgba(0,0,0,0.3);
    position:relative;
}
.popup-content h3{text-align:center; margin-top:0;}
.popup-content .trip-detail{margin:8px 0;}
.popup-content .close{
    position:absolute;
    top:10px; right:15px;
    font-size:20px;
    cursor:pointer;
    color:#333;
}
</style>
</head>
<body>

<!-- TOP HEADER -->
<header class="top-header">
    <div class="logo">Fleet System</div>
    <div class="user-info">
        Welcome Admin | <span><?php echo $_SESSION['name']; ?></span>
        <a href="logout.php" class="logout-btn">Logout</a>
    </div>
</header>

<!-- PAGE TITLE -->
<section class="page-title">
    <h2>Trip Management</h2>
</section>

<!-- ACTION BUTTONS -->
<section class="action-buttons">
    <a href="add_trip.php"><button class="btn primary">➕ Add Trip</button></a>
    <a href="delete_trip.php"><button class="btn danger">🗑 Delete Trip</button></a>
</section>

<!-- FILTER BUTTONS -->
<section class="filters">
    <button class="filter-btn active" onclick="filterTable('all')">All Trips</button>
    <button class="filter-btn" onclick="filterTable('active')">Active Trips</button>
    <button class="filter-btn" onclick="filterTable('future')">Future Trips</button>
    <button class="filter-btn" onclick="filterTable('completed')">Completed Trips</button>
</section>

<!-- TABLE -->
<section class="table-section">
    <table id="tripTable">
        <thead>
            <tr>
                <th>Start Point</th>
                <th>End Point</th>
                <th>Driver Name</th>
                <th>Vehicle Number</th>
                <th>Vehicle Name</th>
                <th>Total Mal Width</th>
                <th>Items</th>
                <th>Total Maintenance</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while($t = mysqli_fetch_assoc($tripsResult)):
                $status = strtolower($t['status']);
            ?>
            <tr data-status="<?php echo $status; ?>">
                <td><?php echo $t['start_point']; ?></td>
                <td><?php echo $t['end_point']; ?></td>
                <td><?php echo $t['driver_name']; ?></td>
                <td><?php echo $t['number_plate']; ?></td>
                <td><?php echo $t['vehicle_model']; ?></td>
                <td><?php echo $t['total_kg'] . ' KG'; ?></td>
                <td><?php echo $t['total_items']; ?></td>
                <td>₹<?php echo number_format($t['total_expense']); ?></td>
                <td><?php echo $t['send_date']; ?></td>
                <td><?php echo $t['end_date']; ?></td>
                <td><button class="view-btn" onclick="viewTrip(<?php echo $t['trip_id']; ?>)">View</button></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</section>

<!-- ===== POPUP ===== -->
<div class="popup" id="tripPopup">
    <div class="popup-content" id="popupContent">
        <span class="close" onclick="closePopup()">&times;</span>
        <h3>Trip Details</h3>
        <div id="popupBody"></div>
        <button onclick="printPopup()">🖨 Print / Download</button>
    </div>
</div>

<script>
function viewTrip(id){
    const popup = document.getElementById("tripPopup");
    const body = document.getElementById("popupBody");
    popup.style.display = "flex";

    fetch("trip_details.php?id="+id)
    .then(res => res.text())
    .then(data => { body.innerHTML = data; });
}

function closePopup(){
    document.getElementById("tripPopup").style.display = "none";
}

function printPopup(){
    const printContents = document.getElementById("popupContent").innerHTML;
    const originalContents = document.body.innerHTML;
    document.body.innerHTML = printContents;
    window.print();
    document.body.innerHTML = originalContents;
    window.location.reload();
}

// FILTER FUNCTION
function filterTable(status){
    const rows = document.querySelectorAll("#tripTable tbody tr");
    rows.forEach(row => {
        if(status === "all") row.style.display = "";
        else row.style.display = (row.getAttribute("data-status") === status) ? "" : "none";
    });
}
</script>

</body>
</html>