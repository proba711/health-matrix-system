<?php
include("../config/db.php");

$result = $conn->query("SELECT * FROM patients ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Patients</title>

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

.badge-waiting{background:#fff3cd;padding:5px 10px;border-radius:20px;}
.badge-admitted{background:#d1fae5;padding:5px 10px;border-radius:20px;}
.badge-referred{background:#ffe4e6;padding:5px 10px;border-radius:20px;}

</style>
</head>

<body>

<div class="wrapper">

<div class="header">

    <h3>🏥 Patients</h3>

    <a href="add_patient.php" class="btn-add">+ Add Patient</a>

</div>

<div class="card-box">

<table class="table table-hover">

<thead>
<tr>
    <th>MR</th>
    <th>Name</th>
    <th>Gender</th>
    <th>Age</th>
    <th>Department</th>
    <th>Doctor</th>
    <th>Status</th>
</tr>
</thead>

<tbody>

<?php while($row = $result->fetch_assoc()) { ?>

<tr>

<td><?= $row['mr_number'] ?></td>
<td><?= $row['full_name'] ?></td>
<td><?= $row['gender'] ?></td>
<td><?= $row['age'] ?></td>
<td><?= $row['department'] ?></td>
<td><?= $row['doctor'] ?></td>

<td>
<?php if($row['status']=="Waiting") echo "<span class='badge-waiting'>Waiting</span>"; ?>
<?php if($row['status']=="Admitted") echo "<span class='badge-admitted'>Admitted</span>"; ?>
<?php if($row['status']=="Referred") echo "<span class='badge-referred'>Referred</span>"; ?>
</td>

</tr>

<?php } ?>

</tbody>

</table>

</div>

</div>

</body>
</html>