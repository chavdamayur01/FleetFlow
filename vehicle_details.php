<?php
include("db/db.php");

if(!isset($_GET['id'])) exit;

$id = intval($_GET['id']);

// Fetch vehicle
$v = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM vehicles WHERE id='$id'"));
if(!$v){ echo "<p>Vehicle not found.</p>"; exit; }

// Fetch total trips
$tripsCount = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM trips WHERE vehicle_id='$id'"))['total'];

// Output HTML for popup
echo "
<div class='vehicle-detail'><strong>Vehicle Name:</strong> {$v['vehicle_model']}</div>
<div class='vehicle-detail'><strong>Vehicle Number:</strong> {$v['number_plate']}</div>
<div class='vehicle-detail'><strong>Fuel Type:</strong> {$v['fuel_type']}</div>
<div class='vehicle-detail'><strong>Capacity:</strong> {$v['capacity']}</div>
<div class='vehicle-detail'><strong>Purchase Date:</strong> {$v['purchase_date']}</div>
<div class='vehicle-detail'><strong>Insurance Expiry:</strong> {$v['insurance_expiry']}</div>
<div class='vehicle-detail'><strong>Status:</strong> {$v['status']}</div>
<div class='vehicle-detail'><strong>Total Trips:</strong> $tripsCount</div>
";
?>