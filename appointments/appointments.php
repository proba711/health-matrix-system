<?php
include("../config/db.php");

$result = $conn->query("SELECT * FROM appointments ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Appointments</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

body{
    background:#f4f6fb;
    font-family:Inter;
}

.wrapper{
    padding:20px;
}

.header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:15px;
}

.btn-add{
    background:#2563eb;
    color:white;
    padding:10px 15px;
    border-radius:10px;
    text-decoration:none;
}

.card-box{
    background:white;
    padding:20px;
    border-radius:15px;
    box-shadow:0 6px 18px rgba(0,0,0,0.05);
}

.table thead{
    background:#1e3a8a;
    color:white;
}

.badge-pending{background:#fff3cd;padding:5px 10px;border-radius:20px;}
.badge-done{background:#d1fae5;padding:5px 10px;border-radius:20px;}
.badge-cancel{background:#ffe4e6;padding:5px 10px;border-radius:20px;}

</style>

</head>

<body>

<div class="wrapper">

<div class="header">

    <h3>📅 Appointments</h3>

    <a href="add_appointment.php" class="btn-add">+ Book Appointment</a>

</div>

<div class="card-box">

<table class="table table-hover">

<thead>
<tr>
    <th>Patient</th>
    <th>Doctor</th>
    <th>Date</th>
    <th>Time</th>
    <th>Status</th>
</tr>
</thead>

<tbody>

<?php while($row = $result->fetch_assoc()) { ?>

<tr>

<td><?= $row['patient_name'] ?></td>
<td><?= $row['doctor'] ?></td>
<td><?= $row['appointment_date'] ?></td>
<td><?= $row['appointment_time'] ?></td>

<td>
<?php if($row['status']=="Pending") echo "<span class='badge-pending'>Pending</span>"; ?>
<?php if($row['status']=="Completed") echo "<span class='badge-done'>Completed</span>"; ?>
<?php if($row['status']=="Cancelled") echo "<span class='badge-cancel'>Cancelled</span>"; ?>
</td>

</tr>

<?php } ?>

</tbody>

</table>

</div>

</div>

</body>
</html>