<?php
session_start();

/* ---------- DATABASE CONNECTION ---------- */
include ('db/db.php');

/* ---------- SAVE DRIVER ---------- */
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name        = $_POST['name'];
    $mobile      = $_POST['mobile'];
    $email       = $_POST['email'];
    $birth_date  = $_POST['birth_date'];
    $aadhar      = $_POST['aadhar'];
    $address     = $_POST['address'];
    $license     = $_POST['license'];
    $license_exp = $_POST['license_expiry'];
    $driver_type = $_POST['driver_type'];
    $joining     = $_POST['joining_date'];
    $emg_name    = $_POST['emg_name'];
    $emg_mobile  = $_POST['emg_mobile'];

    /* ---------- PHOTO UPLOAD ---------- */
    $photo_name = "";
    if (!empty($_FILES['photo']['name'])) {
        $target_dir = "uploads/drivers/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        $photo_name = time() . "_" . $_FILES['photo']['name'];
        move_uploaded_file($_FILES['photo']['tmp_name'], $target_dir . $photo_name);
    }

    try {

        $stmt = $conn->prepare("INSERT INTO drivers
        (name,mobile,email,birth_date,aadhar_number,address,photo,license_number,
        license_expiry,driver_type,joining_date,emergency_contact_name,emergency_contact_number)
        VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)");

        $stmt->bind_param("sssssssssssss",
            $name,$mobile,$email,$birth_date,$aadhar,$address,$photo_name,$license,
            $license_exp,$driver_type,$joining,$emg_name,$emg_mobile
        );

        $stmt->execute();

        echo "<script>alert('Driver Added Successfully');window.location='driver.php';</script>";

    } catch (mysqli_sql_exception $e) {

        if ($e->getCode() == 1062) {
            echo "<script>alert('Driver already exists (License/Aadhar Duplicate)');</script>";
        } else {
            echo "<script>alert('Error inserting data');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Add Driver</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>

/* ---------- HEADER ---------- */
.top-header{
background:#1e293b;
color:white;
padding:15px 25px;
display:flex;
justify-content:space-between;
}

/* ---------- FORM CONTAINER ---------- */
.container{
max-width:900px;
margin:30px auto;
background:white;
padding:25px;
border-radius:10px;
box-shadow:0 5px 20px rgba(0,0,0,0.1);
}

/* ---------- GRID ---------- */
.form-grid{
display:grid;
grid-template-columns:1fr 1fr;
gap:15px;
}

input,select,textarea{
width:100%;
padding:10px;
border:1px solid #ccc;
border-radius:6px;
}

textarea{grid-column:span 2;}

/* ---------- BUTTON ---------- */
button{
margin-top:15px;
padding:12px;
background:#3b82f6;
color:white;
border:none;
border-radius:6px;
cursor:pointer;
width:100%;
}

/* ---------- RESPONSIVE ---------- */
@media(max-width:768px){
.form-grid{grid-template-columns:1fr;}
}

</style>
</head>

<body>

<header class="top-header">
<div>Fleet System</div>
<div>Welcome Admin</div>
</header>

<div class="container">
<h2>Add New Driver</h2>

<form method="POST" enctype="multipart/form-data">
  <div class="form-grid" style="display: grid; gap: 15px; max-width: 500px; margin: auto;">

    <!-- Driver Name -->
    <label for="name">Driver Name <span style="color:red;">*</span></label>
    <input type="text" id="name" name="name" placeholder="Enter driver name" required>

    <!-- Mobile Number -->
    <label for="mobile">Mobile Number <span style="color:red;">*</span></label>
    <input type="text" id="mobile" name="mobile" placeholder="Enter mobile number" required>

    <!-- Email -->
    <label for="email">Email</label>
    <input type="email" id="email" name="email" placeholder="Enter email">

    <!-- Birth Date -->
    <label for="birth_date">Birth Date <span style="color:red;">*</span></label>
    <input type="date" id="birth_date" name="birth_date" required>

    <!-- Aadhar Number -->
    <label for="aadhar">Aadhar Number <span style="color:red;">*</span></label>
    <input type="text" id="aadhar" name="aadhar" placeholder="Enter Aadhar number" required>

    <!-- License Number -->
    <label for="license">License Number <span style="color:red;">*</span></label>
    <input type="text" id="license" name="license" placeholder="Enter license number" required>

    <!-- License Expiry -->
    <label for="license_expiry">License Expiry Date <span style="color:red;">*</span></label>
    <input type="date" id="license_expiry" name="license_expiry" required>

    <!-- Joining Date -->
    <label for="joining_date">Joining Date <span style="color:red;">*</span></label>
    <input type="date" id="joining_date" name="joining_date" required>

    <!-- Driver Type -->
    <label for="driver_type">Driver Type <span style="color:red;">*</span></label>
    <select id="driver_type" name="driver_type" required>
      <option value="">Select driver type</option>
      <option value="2W">Two Wheeler</option>
      <option value="3W">Three Wheeler</option>
      <option value="4W">Four Wheeler</option>
      <option value="HMV">Heavy Vehicle</option>
    </select>

    <!-- Photo Upload -->
    <label for="photo">Driver Photo</label>
    <input type="file" id="photo" name="photo">

    <!-- Emergency Contact Name -->
    <label for="emg_name">Emergency Contact Name</label>
    <input type="text" id="emg_name" name="emg_name" placeholder="Enter emergency contact name">

    <!-- Emergency Contact Mobile -->
    <label for="emg_mobile">Emergency Contact Number</label>
    <input type="text" id="emg_mobile" name="emg_mobile" placeholder="Enter emergency contact number">

    <!-- Address -->
    <label for="address">Address</label>
    <textarea id="address" name="address" placeholder="Enter address" rows="3"></textarea>

    <!-- Submit Button -->
    <button type="submit" style="padding:10px 20px; background-color:#4CAF50; color:white; border:none; cursor:pointer;">
      Save Driver
    </button>

  </div>
</form>


</div>

</body>
</html>