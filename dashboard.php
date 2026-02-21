<?php
session_start();

/* TEMP STATIC USER (later from database) */
$_SESSION['role'] = "Admin";
$_SESSION['name'] = "Mayur";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>

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
        <h3>25</h3>
        <p>Total Vehicles</p>
    </div>

    <div class="card">
        <h3>18</h3>
        <p>Total Drivers</p>
    </div>

    <div class="card">
        <h3>₹42,500</h3>
        <p>Fuel Expense</p>
    </div>

    <div class="card">
        <h3>7</h3>
        <p>Active Trips</p>
    </div>

</section>


<!-- ===== QUICK ACTIONS ===== -->
<section class="quick-actions">
   <a href="vehicals.php"> <button>Add Vehicle</button></a>
    <a href="driver.php"><button>Add Driver</button></a>
   <a href="trip.php"> <button>trip show</button></a>
   <a href="dispacher_add.php"><button> add dispacher</button></a>      
    <button>View Reports</button>
</section>


<!-- ===== ACTIVE TRIPS ===== -->
<section class="panel">
    <h3>Active Trips</h3>

    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>Vehicle No</th>
                    <th>Driver</th>
                    <th>From</th>
                    <th>To</th>
                    <th>Status</th>
                </tr>
            </thead>

            <tbody>
                <tr>
                    <td>GJ01AB1234</td>
                    <td>Ramesh</td>
                    <td>Ahmedabad</td>
                    <td>Surat</td>
                    <td><span class="status running">Running</span></td>
                </tr>

                <tr>
                    <td>GJ05CD5678</td>
                    <td>Suresh</td>
                    <td>Vadodara</td>
                    <td>Rajkot</td>
                    <td><span class="status running">Running</span></td>
                </tr>
            </tbody>
        </table>
    </div>
</section>


<!-- ===== REPORTS ===== -->
<section class="panel">
    <h3>Reports</h3>

    <div class="reports">
        <div class="report-box">Monthly Trip Report</div>
        <div class="report-box">Fuel Analytics</div>
        <div class="report-box">Vehicle Usage</div>
        <div class="report-box">Expense Summary</div>
    </div>
</section>

</div>

</body>
</html>