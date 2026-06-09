<?php
session_start();
include("../config/db.php");

error_reporting(E_ALL);
ini_set('display_errors', 1);

if(!isset($_SESSION['user'])){
    header("Location: ../auth/login.php");
    exit;
}

$patients = $conn->query("SELECT COUNT(*) as t FROM patients")->fetch_assoc()['t'] ?? 0;
$employees = $conn->query("SELECT COUNT(*) as t FROM employees")->fetch_assoc()['t'] ?? 0;
$appointments = $conn->query("SELECT COUNT(*) as t FROM appointments")->fetch_assoc()['t'] ?? 0;
$revenue = $conn->query("SELECT SUM(total) as t FROM bills")->fetch_assoc()['t'] ?? 0;
?>

<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
<title>Health Matrix Dashboard</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
body{
    background:#f5f7ff;
    font-family:Inter;
}

.layout{
    display:flex;
    gap:20px;
    padding:20px;
}

.sidebar-card{
    width:260px;
    background:linear-gradient(180deg,#1e2a78,#2b3bbd);
    border-radius:18px;
    padding:15px;
    color:white;
    height:fit-content;
    position:sticky;
    top:20px;
}

.sidebar-card a{
    display:block;
    padding:10px;
    color:#dbe3ff;
    text-decoration:none;
    border-radius:8px;
}

.sidebar-card a:hover{
    background:rgba(255,255,255,0.15);
    color:white;
}

.main{
    flex:1;
}

.topbar{
    background:#fff;
    padding:14px;
    border-radius:14px;
    display:flex;
    justify-content:space-between;
    align-items:center;
}

.cards{
    display:grid;
    grid-template-columns:repeat(4,1fr);
    gap:15px;
    margin-top:20px;
}

.card-box{
    background:#fff;
    padding:15px;
    border-radius:14px;
    box-shadow:0 5px 15px rgba(0,0,0,0.05);
}

.blue{border-left:5px solid #4da3ff;}
.orange{border-left:5px solid #ffa726;}
.pink{border-left:5px solid #ff5c8a;}
.green{border-left:5px solid #26a69a;}

.table-box{
    background:#fff;
    padding:15px;
    border-radius:14px;
    margin-top:20px;
}
</style>
</head>

<body>

<div class="layout">

<div class="sidebar-card">

<h4>Health Matrix</h4>

<a href="#"><i class="fa fa-home"></i> Dashboard</a>
<a href="../hrm/employees.php"><i class="fa fa-user-md"></i> HRM</a>
<a href="../patients/patients.php"><i class="fa fa-user"></i> Patients</a>
<a href="../appointments/appointments.php"><i class="fa fa-calendar"></i> Appointments</a>
<a href="../billing/bills.php"><i class="fa fa-credit-card"></i> Billing</a>
<a href="users.php"><i class="fa fa-users"></i> Users</a>

<hr style="background:white;">

<a href="../auth/logout.php" style="color:#ffb4b4;">
    <i class="fa fa-sign-out"></i> Logout
</a>

</div>

<div class="main">

<div class="topbar">
<h5>Dashboard</h5>
<input class="form-control w-50" placeholder="Search...">
<div>
<i class="fa fa-bell"></i>
</div>
</div>

<div class="cards">
<div class="card-box blue">
<h4><?= $patients ?></h4>
<small>Patients</small>
</div>
<div class="card-box orange">
<h4><?= $employees ?></h4>
<small>Employees</small>
</div>
<div class="card-box pink">
<h4><?= $appointments ?></h4>
<small>Appointments</small>
</div>
<div class="card-box green">
<h4><?= $revenue ?></h4>
<small>Revenue</small>
</div>
</div>

<div class="table-box">
<h5>Recent Patients</h5>
<table class="table table-hover mt-3">
<thead>
<tr>
<th>Name</th>
<th>Status</th>
<th>Doctor</th>
</tr>
</thead>
<tbody>
<?php
$res = $conn->query("SELECT * FROM patients ORDER BY id DESC LIMIT 5");
while($row = $res->fetch_assoc()){
?>
<tr>
<td><?= $row['full_name'] ?></td>
<td><?= $row['status'] ?></td>
<td><?= $row['doctor'] ?></td>
</tr>
<?php } ?>
</tbody>
</table>
</div>

</div>

</div>

</body>
</html>