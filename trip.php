<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Trip Management</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
 <!-- Add this inside <head> -->
<link rel="stylesheet" href="assets/trip.css">
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
    <h2>Trip Management</h2>
</section>

<!-- ACTION BUTTONS -->
<section class="action-buttons">
    <button class="btn primary">➕ Add Trip</button>
    <button class="btn danger">🗑 Delete Trip</button>
</section>

<!-- FILTER BUTTONS -->
<section class="filters">
    <button class="filter-btn active">All Trips</button>
    <button class="filter-btn">Active Trips</button>
    <button class="filter-btn">Future Trips</button>
    <button class="filter-btn">Completed Trips</button>
</section>

<!-- TABLE -->
<section class="table-section">
    <table>
        <thead>
            <tr>
                <th>Start Point</th>
                <th>End Point</th>
                <th>Driver Name</th>
                <th>vehicle number</th>
                <th>Vehicle Name</th>
                <th>Total Mal Width</th>
                <th>Items</th>
                <th>Total Maintenance</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <!-- STATIC DATA -->
            <tr>
                <td>Ahmedabad</td>
                <td>Surat</td>
                <td>Ramesh Patel</td>
                <td>GJ12AB4035</td>
                <td>Tata 407</td>
                <td>10 Ton</td>
                <td>Electronics, Furniture</td>
                <td>₹5000</td>
             
                <td>2026-02-10</td>
                <td>2026-02-12</td>
              
                <td><button class="view-btn">View</button></td>
            </tr>
            <tr>
                <td>Vadodara</td>
                <td>Rajkot</td>
                <td>Mahesh Kumar</td>
                   <td>GJ12AB4035</td>
                <td>Maruti Van</td>
                 
                <td>5 Ton</td>
                <td>Clothes</td>
                <td>₹3000</td>
              
                <td>2026-02-15</td>
                <td>2026-02-16</td>
          
                <td><button class="view-btn">View</button></td>
            </tr>
            <tr>
                <td>Surat</td>
                <td>Bhavnagar</td>
                <td>Suresh Shah</td>
                   <td>GJ12AB4035</td>
                <td>Tata Ace</td>
                <td>2 Ton</td>
                <td>Food Items</td>
                <td>₹2000</td>
                
                <td>2026-02-18</td>
                <td>2026-02-18</td>
            
                <td><button class="view-btn">View</button></td>
            </tr>
        </tbody>
    </table>
</section>

</body>
</html>