<?php
include("../config/db.php");
session_start();

// fetch employees
$result = $conn->query("SELECT * FROM employees ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Employees - HRM</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
body{
    background:#f5f7ff;
    font-family:Arial;
}

.container-box{
    background:#fff;
    padding:20px;
    border-radius:12px;
    margin:30px;
    box-shadow:0 5px 15px rgba(0,0,0,0.05);
}

.table thead{
    background:#1e3a8a;
    color:white;
}
</style>
</head>

<body>

<div class="container-box">

<h3>👨‍⚕️ Employees (HRM)</h3>

<a href="add_employee.php" class="btn btn-primary mb-3">+ Add Employee</a>

<table class="table table-hover">
<thead>
<tr>
<th>ID</th>
<th>Name</th>
<th>Email</th>
<th>Phone</th>
<th>Department</th>
<th>Role</th>
<th>Status</th>
<th>Actions</th>
</tr>
</thead>

<tbody>

<?php while($row = $result->fetch_assoc()){ ?>

<tr>
<td><?= $row['id'] ?></td>

<!-- FIX HII SEHEMU TU -->
<td><?= $row['name'] ?? $row['full_name'] ?></td>

<td><?= $row['email'] ?></td>
<td><?= $row['phone'] ?></td>
<td><?= $row['department'] ?></td>
<td><?= $row['role'] ?></td>
<td><?= $row['status'] ?></td>

<td>
<a href="edit_employee.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
<a href="delete_employee.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm">Delete</a>
</td>

</tr>

<?php } ?>

</tbody>
</table>

</div>

</body>
</html>