<?php
// SESSION CHECK (later use)
session_start();
?>
<?php
include 'db/db.php';

$status = isset($_GET['status']) ? $_GET['status'] : 'all';

if($status == 'all'){
    $query = "SELECT * FROM drivers ORDER BY driver_id DESC";
} else {
    $query = "SELECT * FROM drivers WHERE status='$status' ORDER BY driver_id DESC";
}

$result = mysqli_query($conn, $query);
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Driver Management</title>
    <link rel="stylesheet" href="assets/driver.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>

<!-- TOP HEADER -->
<header class="top-header">
    <div class="logo">Fleet System</div>

    <div class="user-info">
        Welcome Admin | <span>Mayur</span>
        <a href="logout.php" class="logout-btn">Logout</a>
    </div>
</header>

<!-- PAGE TITLE -->
<section class="page-title">
    <h2>Driver Management</h2>
</section>

<!-- ACTION BUTTONS -->
<section class="action-buttons">
    <a href="add_driver.php"><button class="btn primary">➕ Add Driver</button></a>
    <a href="delete_driver.php"><button class="btn danger">🗑 Delete Driver</button></a>
    <button class="btn warning">📄 Leave Driver</button>
</section>

<!-- FILTER BUTTONS -->
<section class="filters">
    <a href="driver.php?status=all"><button class="filter-btn <?=(!isset($_GET['status']) || $_GET['status']=='all')?'active':''?>">All Drivers</button></a>
    <a href="driver.php?status=Active"><button class="filter-btn <?=isset($_GET['status']) && $_GET['status']=='Active'?'active':''?>">Active Drivers</button></a>
    <a href="driver.php?status=Free"><button class="filter-btn <?=isset($_GET['status']) && $_GET['status']=='inactive'?'inactive':''?>">Free Drivers</button></a>
    <a href="driver.php?status=Leave"><button class="filter-btn <?=isset($_GET['status']) && $_GET['status']=='Leave'?'active':''?>">Leave Drivers</button></a>
    <a href="driver.php?status=Notice"><button class="filter-btn <?=isset($_GET['status']) && $_GET['status']=='Notice'?'active':''?>">Notice Drivers</button></a>
</section>

<!-- TABLE -->
<section class="table-section">

    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Status</th>
                <th>Mobile</th>
                <th>Email</th>
                <th>Action</th>
            </tr>
        </thead>

        <tbody>
        <?php
        if(mysqli_num_rows($result) > 0){
            while($row = mysqli_fetch_assoc($result)){

                // Map status to CSS class
                $status_class = '';
                if($row['status'] == 'active'){
                    $status_class = 'active';
                } elseif($row['status'] == 'inactive'){
                    $status_class = 'free';
                } elseif($row['status'] == 'on_leave'){
                    $status_class = 'leave';
                }

                echo "<tr>
                    <td>".$row['name']."</td>
                    <td><span class='status $status_class'>".$row['status']."</span></td>
                    <td>".$row['mobile']."</td>
                    <td>".$row['email']."</td>
                   <!-- In driver.php table -->
<td><a href='view_driver.php?driver_id=".$row['driver_id']."'>
                <button class='view-btn'>View</button>
            </a></td>
                </tr>";
            }
        } else {
            echo "<tr><td colspan='5'>No drivers found</td></tr>";
        }
        ?>
        </tbody>

    </table>

</section>

</body>
</html>