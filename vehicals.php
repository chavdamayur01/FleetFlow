<?php
session_start();

/* TEMP SESSION (later from login) */
$_SESSION['role'] = "Admin";
$_SESSION['name'] = "Mayur";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vehicle Management</title>

    <link rel="stylesheet" href="assets/vehicle.css">
</head>
<body>

<!-- ===== HEADER ===== -->
<header class="top-header">
    <h2>Welcome <?php echo $_SESSION['role']; ?></h2>

    <div class="right">
        <span><?php echo $_SESSION['name']; ?></span>
        <a href="dashboard.php" class="back-btn">Dashboard</a>
        <a href="logout.php" class="logout-btn">Logout</a>
    </div>
</header>


<div class="container">

    <!-- ===== ACTION BUTTONS ===== -->
    <div class="actions">
        <a href="add_vehicals.php"><button class="primary">+ Add Vehicle</button></a>
        <button class="danger">Delete Vehicle</button>
    </div>

    <!-- ===== FILTER BUTTONS ===== -->
    <div class="filters">
        <button onclick="filterTable('all')">Show All</button>
        <button onclick="filterTable('active')">Active Vehicles</button>
        <button onclick="filterTable('free')">Free Vehicles</button>
        <button onclick="filterTable('maintenance')">Maintenance</button>
    </div>

    <!-- ===== VEHICLE TABLE ===== -->
    <div class="table-box">
        <table id="vehicleTable">
            <thead>
                <tr>
                    <th>Vehicle No</th>
                    <th>Model</th>
                    <th>Capacity</th>
                    <th>Status</th>
                    <th>Location</th>
                </tr>
            </thead>

            <tbody>
                <tr data-status="active">
                    <td>GJ01AB1234</td>
                    <td>Tata 407</td>
                    <td>2500 KG</td>
                    <td><span class="status active">Active</span></td>
                    <td>Ahmedabad → Surat</td>
                </tr>

                <tr data-status="free">
                    <td>GJ05CD5678</td>
                    <td>Eicher Pro</td>
                    <td>3000 KG</td>
                    <td><span class="status free">Free</span></td>
                    <td>Warehouse</td>
                </tr>

                <tr data-status="maintenance">
                    <td>GJ03EF9087</td>
                    <td>Mahindra Pickup</td>
                    <td>1800 KG</td>
                    <td><span class="status maintenance">Maintenance</span></td>
                    <td>Service Center</td>
                </tr>
            </tbody>
        </table>
    </div>

</div>

<script>
function filterTable(type) {
    let rows = document.querySelectorAll("#vehicleTable tbody tr");

    rows.forEach(row => {
        if (type === "all") {
            row.style.display = "";
        } else {
            row.style.display =
                row.getAttribute("data-status") === type ? "" : "none";
        }
    });
}
</script>

</body>
</html>