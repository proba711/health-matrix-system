<?php
include("../config/db.php");

$id = $_GET['id'];
$data = $conn->query("SELECT * FROM employees WHERE id=$id")->fetch_assoc();

if(isset($_POST['update'])){

    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $dept = $_POST['department'];
    $role = $_POST['role'];
    $status = $_POST['status'];

    $conn->query("UPDATE employees SET 
        full_name='$name',
        email='$email',
        phone='$phone',
        department='$dept',
        role='$role',
        status='$status'
        WHERE id=$id
    ");

    header("Location: employees.php");
}
?>

<!DOCTYPE html>
<html>
<head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body{background:#f4f6fb;font-family:Inter;}
.box{max-width:650px;margin:40px auto;background:white;padding:25px;border-radius:15px;}
input,select{margin-bottom:10px;}
.btn{width:100%;}
</style>
</head>

<body>

<div class="box">

<h3> Edit Employee</h3>

<form method="POST">

<input name="name" class="form-control" value="<?= $data['full_name'] ?>">
<input name="email" class="form-control" value="<?= $data['email'] ?>">
<input name="phone" class="form-control" value="<?= $data['phone'] ?>">
<input name="department" class="form-control" value="<?= $data['department'] ?>">
<input name="role" class="form-control" value="<?= $data['role'] ?>">

<select name="status" class="form-control">
    <option <?= $data['status']=='Active'?'selected':'' ?>>Active</option>
    <option <?= $data['status']=='Inactive'?'selected':'' ?>>Inactive</option>
</select>

<button name="update" class="btn btn-primary">Update</button>

</form>

</div>

</body>
</html>