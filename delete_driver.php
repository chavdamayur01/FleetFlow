<?php
include 'db/db.php';

// Handle delete action
if(isset($_GET['delete_id'])){
    $delete_id = intval($_GET['delete_id']);
    mysqli_query($conn, "DELETE FROM drivers WHERE driver_id = $delete_id");
    header("Location: delete_driver.php"); // redirect to refresh list
    exit;
}

// Fetch all drivers
$result = mysqli_query($conn, "SELECT * FROM drivers ORDER BY driver_id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Delete Driver</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Roboto', sans-serif; background: #f7f8fa; margin:0; padding:0; }
        .container { max-width: 1000px; margin: 50px auto; background: #fff; padding: 30px; border-radius: 12px; box-shadow: 0 8px 25px rgba(0,0,0,0.1); }
        h1 { text-align: center; margin-bottom: 30px; color:#333; }
        table { width: 100%; border-collapse: collapse; }
        table thead tr { background: #4CAF50; color: #fff; }
        table th, table td { padding: 12px 15px; text-align: left; border-bottom: 1px solid #ddd; }
        table tbody tr:hover { background: #f1f1f1; }
        .delete-btn { background: #f44336; color: #fff; border: none; padding: 8px 15px; border-radius: 5px; cursor: pointer; transition: 0.3s; }
        .delete-btn:hover { background: #d32f2f; }
        .back-btn { display: inline-block; margin-top: 20px; padding: 10px 20px; background:#4CAF50; color:white; text-decoration:none; border-radius:5px; }
    </style>
    <script>
        function confirmDelete(driverName, deleteId){
            if(confirm("Are you sure you want to delete " + driverName + "?")){
                window.location.href = "delete_driver.php?delete_id=" + deleteId;
            }
        }
    </script>
</head>
<body>

<div class="container">
    <h1>Delete Drivers</h1>

    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Mobile</th>
                <th>Email</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        <?php if(mysqli_num_rows($result) > 0): ?>
            <?php while($row = mysqli_fetch_assoc($result)): ?>
                <?php
                    // Map status to label
                    $status_text = ucfirst($row['status']);
                ?>
                <tr>
                    <td><?php echo $row['name']; ?></td>
                    <td><?php echo $row['mobile']; ?></td>
                    <td><?php echo $row['email']; ?></td>
                    <td><?php echo $status_text; ?></td>
                    <td>
                        <button class="delete-btn" onclick="confirmDelete('<?php echo $row['name']; ?>', <?php echo $row['driver_id']; ?>)">Delete</button>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="5" style="text-align:center;">No drivers found</td></tr>
        <?php endif; ?>
        </tbody>
    </table>

    <a href="driver.php" class="back-btn">← Back to Driver Management</a>
</div>

</body>
</html>