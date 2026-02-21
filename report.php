<?php
session_start();
include("db/db.php");

// Role check
if(!isset($_SESSION['logged_in']) || $_SESSION['role'] != 'admin'){
    header("Location: login.php");
    exit();
}

// Default dates: this month
$startDate = isset($_GET['start_date']) ? $_GET['start_date'] : date('Y-m-01');
$endDate   = isset($_GET['end_date']) ? $_GET['end_date'] : date('Y-m-t');

// Fetch report data
$result = mysqli_query($conn, "
    SELECT status,
           COUNT(*) AS total_trips,
           SUM(fuel_expense) AS total_fuel,
           SUM(other_cost) AS total_maintenance
    FROM trips
    WHERE send_date BETWEEN '$startDate' AND '$endDate'
    GROUP BY status
");

// Prepare arrays for charts
$statuses = ['active'=>0,'completed'=>0,'future'=>0];
$fuelData = ['active'=>0,'completed'=>0,'future'=>0];
$maintData = ['active'=>0,'completed'=>0,'future'=>0];

while($row = mysqli_fetch_assoc($result)){
    $status = $row['status'];
    $statuses[$status] = (int)$row['total_trips'];
    $fuelData[$status]   = (int)$row['total_fuel'];
    $maintData[$status]  = (int)$row['total_maintenance'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Trip Reports</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="assets/trip_reports.css">
<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<style>
body{font-family: 'Roboto', sans-serif; background:#f5f5f5; margin:0;}
.top-header{display:flex; justify-content:space-between; align-items:center; padding:15px 20px; background:#222; color:#fff;}
.top-header .logo{font-weight:700; font-size:20px;}
.top-header .user-info a{color:#fff; text-decoration:none; margin-left:10px; padding:5px 10px; border-radius:5px; background:#e74c3c;}
.page-title{padding:20px; font-size:24px; font-weight:500;}
.filter-form{padding:0 20px 20px;}
.filter-form input{padding:8px; margin-right:10px; border-radius:5px; border:1px solid #ccc;}
.filter-form button{padding:8px 15px; border:none; background:#3498db; color:#fff; border-radius:5px; cursor:pointer;}
.charts{display:flex; flex-wrap:wrap; gap:30px; padding:0 20px 50px;}
.chart-box{background:#fff; padding:20px; border-radius:10px; flex:1; min-width:300px; box-shadow:0 2px 8px rgba(0,0,0,0.1);}
.chart-box h3{text-align:center; margin-bottom:15px;}
</style>
</head>
<body>

<header class="top-header">
    <div class="logo">Fleet System</div>
    <div class="user-info">
        Welcome Admin | <span><?php echo $_SESSION['name']; ?></span>
        <a href="logout.php">Logout</a>
    </div>
</header>

<section class="page-title">
    Trip Reports
</section>

<!-- DATE FILTER FORM -->
<section class="filter-form">
    <form method="get" action="">
        <label>From: <input type="date" name="start_date" value="<?php echo $startDate; ?>"></label>
        <label>To: <input type="date" name="end_date" value="<?php echo $endDate; ?>"></label>
        <button type="submit">Generate</button>
    </form>
</section>

<section class="charts">
    <div class="chart-box">
        <h3>Total Trips</h3>
        <canvas id="tripsChart"></canvas>
    </div>
    <div class="chart-box">
        <h3>Fuel Expense (₹)</h3>
        <canvas id="fuelChart"></canvas>
    </div>
    <div class="chart-box">
        <h3>Maintenance Cost (₹)</h3>
        <canvas id="maintChart"></canvas>
    </div>
</section>

<script>
const tripData = {
    labels: ['Active','Completed','Future'],
    datasets:[{
        label:'Total Trips',
        data:[<?php echo implode(',', $statuses); ?>],
        backgroundColor:['#2ecc71','#95a5a6','#3498db']
    }]
};

const fuelDataSet = {
    labels:['Active','Completed','Future'],
    datasets:[{
        label:'Fuel Expense',
        data:[<?php echo implode(',', $fuelData); ?>],
        backgroundColor:['#2ecc71','#95a5a6','#3498db']
    }]
};

const maintDataSet = {
    labels:['Active','Completed','Future'],
    datasets:[{
        label:'Maintenance Cost',
        data:[<?php echo implode(',', $maintData); ?>],
        backgroundColor:['#2ecc71','#95a5a6','#3498db']
    }]
};

new Chart(document.getElementById('tripsChart'), { type:'bar', data:tripData, options:{ responsive:true, plugins:{ legend:{ display:false } } } });
new Chart(document.getElementById('fuelChart'), { type:'bar', data:fuelDataSet, options:{ responsive:true, plugins:{ legend:{ display:false } } } });
new Chart(document.getElementById('maintChart'), { type:'bar', data:maintDataSet, options:{ responsive:true, plugins:{ legend:{ display:false } } } });
</script>

</body>
</html>