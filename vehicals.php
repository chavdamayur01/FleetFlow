<?php
session_start();
include("db/db.php"); // Database connection

// Role check
if(!isset($_SESSION['logged_in']) || $_SESSION['role'] != 'Admin'){
    header("Location: login.php");
    exit();
}

// Fetch all vehicles
$vehiclesResult = mysqli_query($conn, "
    SELECT * FROM vehicles 
    ORDER BY vehicle_model ASC
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
/* Popup Styles */
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
    width:400px;
    max-width:90%;
    box-shadow:0 5px 15px rgba(0,0,0,0.3);
}
.popup-content h3{
    margin-top:0;
    text-align:center;
}
.popup-content .vehicle-detail{
    margin:10px 0;
    line-height:1.5;
}
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
                <tr data-status="<?php echo $statusClass; ?>">
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