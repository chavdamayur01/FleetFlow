<?php
include 'db/db.php';

if(!isset($_GET['driver_id'])){
    die("No driver selected");
}

$driver_id = intval($_GET['driver_id']); // sanitize input

$query = "SELECT * FROM drivers WHERE driver_id = $driver_id LIMIT 1";
$result = mysqli_query($conn, $query);

if(mysqli_num_rows($result) == 0){
    die("Driver not found");
}

$driver = mysqli_fetch_assoc($result);

// Map status to CSS class
$status_class = '';
$status_text = ucfirst($driver['status']);
if($driver['status'] == 'active') $status_class = 'status-active';
elseif($driver['status'] == 'inactive') $status_class = 'status-free';
elseif($driver['status'] == 'on_leave') $status_class = 'status-leave';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Driver Details - <?php echo $driver['name']; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f7f8fa;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 900px;
            margin: 50px auto;
            background-color: #fff;
            border-radius: 12px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
            padding: 30px 40px;
        }

        .driver-header {
            display: flex;
            align-items: center;
            gap: 30px;
            margin-bottom: 30px;
            flex-wrap: wrap;
        }

        .driver-photo {
            width: 150px;
            height: 150px;
            border-radius: 12px;
            object-fit: cover;
            border: 3px solid #4CAF50;
        }

        .driver-name-status {
            flex: 1;
        }

        .driver-name-status h1 {
            margin: 0;
            font-size: 28px;
            color: #333;
        }

        .driver-status {
            display: inline-block;
            margin-top: 10px;
            padding: 5px 15px;
            border-radius: 20px;
            font-weight: 500;
            font-size: 14px;
            color: #fff;
        }

        .status-active { background-color: #4CAF50; }
        .status-free { background-color: #2196F3; }
        .status-leave { background-color: #FF9800; }

        .driver-info {
            display: grid;
            grid-template-columns: 200px 1fr;
            row-gap: 15px;
            column-gap: 20px;
        }

        .driver-info div {
            padding: 5px 0;
        }

        .driver-info div strong {
            color: #555;
        }

        .back-btn {
            display: inline-block;
            margin-top: 30px;
            padding: 12px 25px;
            background: #4CAF50;
            color: #fff;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 500;
            transition: background 0.3s ease;
        }

        .back-btn:hover {
            background: #45a049;
        }

        @media (max-width: 600px){
            .driver-header {
                flex-direction: column;
                align-items: center;
                text-align: center;
            }

            .driver-info {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>

<div class="container">

    <div class="driver-header">
        <!-- Driver Photo -->
        <?php if(!empty($driver['photo'])): ?>
            <img src="uploads/drivers/<?php echo $driver['photo']; ?>" alt="<?php echo $driver['name']; ?>" class="driver-photo">
        <?php else: ?>
            <img src="uploads/default.png" alt="No Photo" class="driver-photo">
        <?php endif; ?>

        <div class="driver-name-status">
            <h1><?php echo $driver['name']; ?></h1>
            <span class="driver-status <?php echo $status_class; ?>"><?php echo $status_text; ?></span>
        </div>
    </div>

    <!-- Driver Details -->
    <div class="driver-info">
        <div><strong>Mobile:</strong></div><div><?php echo $driver['mobile']; ?></div>
        <div><strong>Email:</strong></div><div><?php echo $driver['email']; ?></div>
        <div><strong>Birth Date:</strong></div><div><?php echo $driver['birth_date']; ?></div>
        <div><strong>Aadhar:</strong></div><div><?php echo $driver['aadhar_number']; ?></div>
        <div><strong>Address:</strong></div><div><?php echo $driver['address']; ?></div>
        <div><strong>License Number:</strong></div><div><?php echo $driver['license_number']; ?></div>
        <div><strong>License Expiry:</strong></div><div><?php echo $driver['license_expiry']; ?></div>
        <div><strong>Driver Type:</strong></div><div><?php echo $driver['driver_type']; ?></div>
        <div><strong>Joining Date:</strong></div><div><?php echo $driver['joining_date']; ?></div>
        <div><strong>Emergency Contact:</strong></div><div><?php echo $driver['emergency_contact_name']; ?> - <?php echo $driver['emergency_contact_number']; ?></div>
        <div><strong>Created At:</strong></div><div><?php echo $driver['created_at']; ?></div>
    </div>

    <a href="driver.php" class="back-btn">← Back to Drivers</a>
</div>

</body>
</html>