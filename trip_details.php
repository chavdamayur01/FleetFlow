<?php
include("db/db.php");
if(!isset($_GET['id'])) exit;

$id = intval($_GET['id']);

// Fetch trip with driver and vehicle
$t = mysqli_fetch_assoc(mysqli_query($conn, "
    SELECT t.*, d.name AS driver_name, v.vehicle_model, v.number_plate
    FROM trips t
    JOIN drivers d ON t.driver_id=d.driver_id
    JOIN vehicles v ON t.vehicle_id=v.id
    WHERE t.trip_id='$id'
"));
if(!$t){ echo "<p>Trip not found.</p>"; exit; }

// Show trip details
echo "
<div class='trip-detail'><strong>Start Point:</strong> {$t['start_point']}</div>
<div class='trip-detail'><strong>End Point:</strong> {$t['end_point']}</div>
<div class='trip-detail'><strong>Driver:</strong> {$t['driver_name']}</div>
<div class='trip-detail'><strong>Vehicle:</strong> {$t['vehicle_model']} ({$t['number_plate']})</div>
<div class='trip-detail'><strong>Total Items:</strong> {$t['total_items']}</div>
<div class='trip-detail'><strong>Total KG:</strong> {$t['total_kg']} KG</div>
<div class='trip-detail'><strong>Total Expense:</strong> ₹{$t['total_expense']}</div>
<div class='trip-detail'><strong>Fuel Expense:</strong> ₹{$t['fuel_expense']}</div>
<div class='trip-detail'><strong>Other Cost:</strong> ₹{$t['other_cost']}</div>
<div class='trip-detail'><strong>Other Cost Description:</strong> {$t['description_other_cost']}</div>
<div class='trip-detail'><strong>Total Distance:</strong> {$t['total_distance']} KM</div>
<div class='trip-detail'><strong>Status:</strong> {$t['status']}</div>
<div class='trip-detail'><strong>Start Date:</strong> {$t['send_date']}</div>
<div class='trip-detail'><strong>End Date:</strong> {$t['end_date']}</div>
";
?>