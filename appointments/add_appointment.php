<?php
include("../config/db.php");

if(isset($_POST['save'])){

    $patient = $_POST['patient'];
    $doctor = $_POST['doctor'];
    $date = $_POST['date'];
    $time = $_POST['time'];

    $conn->query("INSERT INTO appointments(patient_name,doctor,appointment_date,appointment_time)
    VALUES('$patient','$doctor','$date','$time')");

    header("Location: appointments.php");
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Book Appointment</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body{background:#f4f6fb;font-family:Inter;}
.box{max-width:600px;margin:40px auto;background:white;padding:20px;border-radius:15px;}
</style>

</head>

<body>

<div class="box">

<h3> Book Appointment</h3>

<form method="POST">

<input name="patient" class="form-control mb-2" placeholder="Patient Name">
<input name="doctor" class="form-control mb-2" placeholder="Doctor Name">
<input type="date" name="date" class="form-control mb-2">
<input type="time" name="time" class="form-control mb-2">

<button name="save" class="btn btn-primary w-100">Save Appointment</button>

</form>

</div>

</body>
</html>