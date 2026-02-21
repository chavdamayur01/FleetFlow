<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include ('db/db.php');

$msg = "";
// SAVE DATA
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $number_plate      = trim($_POST['number_plate']);
    $vehicle_model     = trim($_POST['vehicle_model']);
    $fuel_type         = trim($_POST['fuel_type']);
    $capacity          = (int)$_POST['capacity'];
    $purchase_date     = $_POST['purchase_date'];
    $insurance_expiry  = $_POST['insurance_expiry'];

    try {

        $stmt = $conn->prepare("INSERT INTO vehicles
        (number_plate, vehicle_model, fuel_type, capacity, purchase_date, insurance_expiry)
        VALUES (?,?,?,?,?,?)");

        $stmt->bind_param("sssiss",
            $number_plate,
            $vehicle_model,
            $fuel_type,
            $capacity,
            $purchase_date,
            $insurance_expiry
        );

        $stmt->execute();

        echo "<script>
                alert('✅ Vehicle Added Successfully');
                window.location.href='vehicals.php';
              </script>";
        exit;

    } catch (mysqli_sql_exception $e) {

        if ($e->getCode() == 1062) {

            echo "<script>
                    alert('⚠️ This Vehicle Already Exists!');
                    window.location.href='vehicals.php';
                  </script>";
            exit;

        } else {

            echo "<script>
                    alert('Database Error!');
                  </script>";
            exit;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Add Vehicle</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>
/* ---------- GLOBAL ---------- */
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family: 'Segoe UI', sans-serif;
}
body{
    background:linear-gradient(135deg,#0f172a,#1e293b);
    color:#fff;
    min-height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
}

/* ---------- CARD ---------- */
.container{
    width:95%;
    max-width:900px;
    background:#111827;
    border-radius:20px;
    padding:35px;
    box-shadow:0 20px 60px rgba(0,0,0,.6);
    animation:fadeIn .6s ease;
}

@keyframes fadeIn{
    from{opacity:0;transform:translateY(20px);}
    to{opacity:1;transform:translateY(0);}
}

h2{
    text-align:center;
    margin-bottom:25px;
    font-weight:600;
    letter-spacing:.5px;
}

/* ---------- FORM GRID ---------- */
.form-grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(250px,1fr));
    gap:20px;
}

/* ---------- INPUT ---------- */
.form-group label{
    display:block;
    margin-bottom:6px;
    font-size:14px;
    color:#cbd5e1;
}

.form-group input,
.form-group select{
    width:100%;
    padding:12px 14px;
    border:none;
    border-radius:10px;
    background:#1f2937;
    color:#fff;
    font-size:14px;
    outline:none;
    transition:.3s;
}

.form-group input:focus,
.form-group select:focus{
    background:#111827;
    box-shadow:0 0 0 2px #3b82f6;
}

/* ---------- BUTTON ---------- */
.btn{
    margin-top:25px;
    width:100%;
    padding:14px;
    border:none;
    border-radius:12px;
    background:linear-gradient(135deg,#3b82f6,#06b6d4);
    color:#fff;
    font-size:16px;
    cursor:pointer;
    transition:.3s;
}

.btn:hover{
    transform:translateY(-2px);
    box-shadow:0 10px 25px rgba(59,130,246,.4);
}

/* ---------- MESSAGE ---------- */
.msg{
    text-align:center;
    margin-bottom:15px;
    font-weight:500;
    color:#22c55e;
}

/* ---------- RESPONSIVE ---------- */
@media(max-width:500px){
    .container{padding:25px 20px;}
}
</style>
</head>

<body>

<div class="container">
    <h2>🚚 Add New Vehicle</h2>

    

    <form method="POST">
        <div class="form-grid">

            <div class="form-group">
                <label>Number Plate</label>
                <input type="text" name="number_plate" required>
            </div>

            <div class="form-group">
                <label>Vehicle Model</label>
                <input type="text" name="vehicle_model" required>
            </div>

            <div class="form-group">
                <label>Fuel Type</label>
                <select name="fuel_type" required>
                    <option value="">Select</option>
                    <option>Petrol</option>
                    <option>Diesel</option>
                    <option>CNG</option>
                    <option>Electric</option>
                </select>
            </div>

            <div class="form-group">
                <label>Capacity</label>
                <input type="number" name="capacity" required>
            </div>

            <div class="form-group">
                <label>Purchase Date</label>
                <input type="date" name="purchase_date" required>
            </div>

            <div class="form-group">
                <label>Insurance Expiry</label>
                <input type="date" name="insurance_expiry" required>
            </div>

        </div>

        <button class="btn">Add Vehicle</button>
    </form>
</div>

</body>
</html>