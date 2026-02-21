<?php
session_start();
include("db/db.php");

// Role-based access
if(!isset($_SESSION['logged_in']) || $_SESSION['role'] != 'dispatcher'){
    header("Location: dashboard.php");
    exit();
}

// Fetch drivers
$drivers_result = mysqli_query($conn, "SELECT driver_id, name FROM drivers WHERE status='inactive' ORDER BY name ASC");

// Fetch vehicles
$vehicles_result = mysqli_query($conn, "SELECT id, vehicle_model, number_plate, capacity FROM vehicles WHERE status='Active' ORDER BY vehicle_model ASC");

$error = "";
$success = "";

// Handle form submission
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $start_point = $_POST['start_point'];
    $end_point = $_POST['end_point'];
    $driver_id = $_POST['driver_id'];
    $vehicle_id = $_POST['vehicle_id'];
    $total_items = $_POST['total_items'];
    $total_kg = $_POST['total_kg'];
    $send_date = $_POST['send_date'];
    $end_date = $_POST['end_date'];
    $total_km = $_POST['total_km'];

    // Check vehicle capacity
    $vehicle_check = mysqli_query($conn, "SELECT capacity FROM vehicles WHERE id='$vehicle_id' AND status='Active'");
    if(mysqli_num_rows($vehicle_check) == 0){
        $error = "Selected vehicle is not available!";
    } else {
        $vehicle_data = mysqli_fetch_assoc($vehicle_check);
        if($total_kg > $vehicle_data['capacity']){
            $error = "Total KG exceeds vehicle capacity ({$vehicle_data['capacity']} KG)!";
        } else {
            // Insert into trips
            
// Insert into trips
$stmt = $conn->prepare("INSERT INTO trips (start_point, end_point, driver_id, vehicle_id, total_items, total_kg, send_date, end_date, total_km, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 'future')");
$stmt->bind_param("ssiissssi", $start_point, $end_point, $driver_id, $vehicle_id, $total_items, $total_kg, $send_date, $end_date, $total_km);

// After successful trip insert
if($stmt->execute()){
    $success = "Trip created successfully!";
    
    // Update vehicle status
    mysqli_query($conn, "UPDATE vehicles SET status='On_Trip' WHERE id='$vehicle_id'");
    
    // ✅ Update driver status to active
    mysqli_query($conn, "UPDATE drivers SET status='active' WHERE driver_id='$driver_id'");
    
} else {
    $error = "Error creating trip: " . $stmt->error;
      }
    }
}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Create Trip</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
<style>
body { font-family: 'Roboto', sans-serif; background-color: #f7f9fc; margin: 0; padding: 0; }
.top-header { background-color: #0d6efd; color: #fff; display: flex; justify-content: space-between; align-items: center; padding: 15px 30px; box-shadow: 0 2px 6px rgba(0,0,0,0.2);}
.top-header .logo { font-weight: 700; font-size: 1.4em;}
.top-header .user-info span { font-weight: 500;}
.logout-btn { background-color: #ffc107; color: #000; padding: 6px 12px; text-decoration: none; border-radius: 5px; margin-left: 10px;}
.form-section { max-width: 800px; margin: 40px auto; background-color: #fff; padding: 30px; border-radius: 12px; box-shadow: 0 5px 15px rgba(0,0,0,0.1);}
.form-section h2 { text-align: center; margin-bottom: 25px; color: #0d6efd;}
.trip-form label { display: block; margin-top: 15px; font-weight: 500;}
.trip-form input, .trip-form select { width: 100%; padding: 10px; margin-top: 5px; border: 1px solid #ccc; border-radius: 8px; box-sizing: border-box; font-size: 1em; transition: all 0.2s;}
.trip-form input:focus, .trip-form select:focus { border-color: #0d6efd; box-shadow: 0 0 5px rgba(13,110,253,0.3); outline: none;}
.btn { margin-top: 25px; padding: 12px 20px; font-size: 1em; border: none; border-radius: 8px; cursor: pointer; transition: all 0.2s;}
.btn.primary { background-color: #0d6efd; color: #fff;}
.btn.primary:hover { background-color: #0b5ed7; }
.error-msg { color: red; text-align: center; margin-top: 10px; }
.success-msg { color: green; text-align: center; margin-top: 10px; }
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

<section class="form-section">
    <h2>Create New Trip</h2>

    <?php if($error) echo "<p class='error-msg'>$error</p>"; ?>
    <?php if($success) echo "<p class='success-msg'>$success</p>"; ?>

    <form action="" method="post" class="trip-form">
        <label>Start Point</label>
        <input type="text" name="start_point" required>

        <label>End Point</label>
        <input type="text" name="end_point" required>

        <label>Total Items</label>
        <input type="text" name="total_items" placeholder="E.g., Electronics, Furniture" required>

        <label>Total KG</label>
        <input type="number" name="total_kg" min="1" required>

        <label>Start Date</label>
        <input type="date" name="send_date" required>

        <label>End Date</label>
        <input type="date" name="end_date" required>

        <label>Total KM</label>
        <input type="number" name="total_km" min="1" required>

        <label>Driver</label>
        <select name="driver_id" required>
            <option value="">-- Select Driver --</option>
            <?php while($driver = mysqli_fetch_assoc($drivers_result)): ?>
                <option value="<?php echo $driver['driver_id']; ?>"><?php echo $driver['name']; ?></option>
            <?php endwhile; ?>
        </select>

        <label>Vehicle</label>
        <select name="vehicle_id" required>
            <option value="">-- Select Vehicle --</option>
            <?php
            mysqli_data_seek($vehicles_result, 0); 
            while($vehicle = mysqli_fetch_assoc($vehicles_result)):
                echo "<option value='{$vehicle['id']}' data-capacity='{$vehicle['capacity']}'>{$vehicle['vehicle_model']} ({$vehicle['number_plate']}) - Capacity: {$vehicle['capacity']} KG</option>";
            endwhile;
            ?>
        </select>

        <button type="submit" class="btn primary">Create Trip</button>
    </form>
</section>

<script>
const kgInput = document.querySelector('input[name="total_kg"]');
const vehicleSelect = document.querySelector('select[name="vehicle_id"]');

kgInput.addEventListener('input', () => {
    const kg = parseInt(kgInput.value);
    for(let i=1; i<vehicleSelect.options.length; i++){
        const option = vehicleSelect.options[i];
        const capacity = parseInt(option.dataset.capacity);
        option.style.display = (capacity >= kg) ? 'block' : 'none';
    }
});
</script>

</body>
</html>