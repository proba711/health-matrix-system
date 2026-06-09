<?php
include("../config/db.php");

if(isset($_POST['save'])){

    $mr = "MR".rand(1000,9999);
    $name = $_POST['name'];
    $gender = $_POST['gender'];
    $age = $_POST['age'];
    $phone = $_POST['phone'];
    $dept = $_POST['department'];
    $doctor = $_POST['doctor'];

    $conn->query("INSERT INTO patients(mr_number,full_name,gender,age,phone,department,doctor)
    VALUES('$mr','$name','$gender','$age','$phone','$dept','$doctor')");

    header("Location: patients.php");
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Add Patient</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body{background:#f4f6fb;font-family:Inter;}
.box{max-width:600px;margin:40px auto;background:white;padding:20px;border-radius:15px;}
</style>
</head>

<body>

<div class="box">

<h3>➕ Add Patient</h3>

<form method="POST">

<input name="name" class="form-control mb-2" placeholder="Full Name">
<select name="gender" class="form-control mb-2">
    <option>Male</option>
    <option>Female</option>
</select>

<input name="age" class="form-control mb-2" placeholder="Age">
<input name="phone" class="form-control mb-2" placeholder="Phone">
<input name="department" class="form-control mb-2" placeholder="Department">
<input name="doctor" class="form-control mb-2" placeholder="Doctor">

<button name="save" class="btn btn-primary w-100">Save Patient</button>

</form>

</div>

</body>
</html>