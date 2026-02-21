<?php
session_start();
include("db/db.php"); // Database connection

// Role check
if(!isset($_SESSION['logged_in']) || $_SESSION['role'] != 'admin'){
    header("Location: login.php");
    exit();
}

// Fetch vehicles with total trips
$vehiclesResult = mysqli_query($conn, "
    SELECT v.id, v.number_plate, v.vehicle_model, v.insurance_expiry, v.status,
           (SELECT COUNT(*) FROM trips t WHERE t.vehicle_id=v.id) as total_trips
    FROM vehicles v
    ORDER BY v.vehicle_model ASC
");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Vehicle Management</title>
<link rel="stylesheet" href="assets/vehicle.css">
<style>
/* Popup styling */
.popup {display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.6); z-index:9999; justify-content:center; align-items:center;}
.popup-content {background:#fff; padding:20px; border-radius:10px; width:600px; max-width:95%;}
.close {float:right; cursor:pointer; font-size:20px; font-weight:bold;}
.trip-detail {margin-bottom:10px;}
.actions {margin-bottom:10px;}
.actions button {margin-right:10px;}
.status.active {color:green;font-weight:bold;}
.status.on_trip {color:orange;font-weight:bold;}
.status.maintenance {color:red;font-weight:bold;}
.status.inactive {color:gray;font-weight:bold;}
</style>
</head>
<body>

<header class="top-header">
    <h2>Welcome <?php echo $_SESSION['role']; ?></h2>
    <div class="right">
        <span><?php echo $_SESSION['name']; ?></span>
        <a href="dashboard.php" class="back-btn">Dashboard</a>
        <a href="logout.php" class="logout-btn">Logout</a>
    </div>
</header>

<div class="container">

    <!-- ===== ACTION BUTTONS ABOVE TABLE ===== -->
    <div class="actions">
        <a href="add_vehicals.php"><button class="primary">+ Add Vehicle</button></a>
        <a href="delete_vehicals.php"><button class="danger">Delete Vehicle</button></a>
    </div>

    <!-- ===== VEHICLE TABLE ===== -->
    <div class="table-box">
        <table id="vehicleTable">
            <thead>
                <tr>
                    <th>Vehicle Name</th>
                    <th>Vehicle No</th>
                    <th>Insurance Expiry</th>
                    <th>Status</th>
                    <th>View</th>
                </tr>
            </thead>
            <tbody>
                <?php while($v = mysqli_fetch_assoc($vehiclesResult)):
                    $statusClass = strtolower(str_replace(' ','_',$v['status']));
                ?>
                <tr>
                    <td><?php echo $v['vehicle_model']; ?></td>
                    <td><?php echo $v['number_plate']; ?></td>
                    <td><?php echo $v['insurance_expiry']; ?></td>
                    <td><span class="status <?php echo $statusClass; ?>"><?php echo $v['status']; ?></span></td>
                    <td><button class="view-btn" onclick="viewVehicle(<?php echo $v['id']; ?>)">View</button></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

</div>

<!-- ===== POPUP ===== -->
<div class="popup" id="vehiclePopup">
    <div class="popup-content" id="popupContent">
        <span class="close" onclick="closePopup()">&times;</span>
        <h3>Vehicle Details</h3>
        <div id="popupBody"></div>
        <button onclick="printPopup()">🖨 Print / Download</button>
    </div>
</div>

<script>
function viewVehicle(id){
    const popup = document.getElementById("vehiclePopup");
    const body = document.getElementById("popupBody");
    popup.style.display = "flex";

    fetch("vehicle_details.php?id="+id)
    .then(res => res.text())
    .then(data => { body.innerHTML = data; });
}

function closePopup(){
    document.getElementById("vehiclePopup").style.display = "none";
}

function printPopup(){
    const printContents = document.getElementById("popupContent").innerHTML;
    const originalContents = document.body.innerHTML;
    document.body.innerHTML = printContents;
    window.print();
    document.body.innerHTML = originalContents;
    window.location.reload();
}
</script>

</body>
</html>