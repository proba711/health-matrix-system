<?php
include("../config/db.php");

if(isset($_POST['save'])){

    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $department = $_POST['department'];
    $role = $_POST['role'];

    $conn->query("INSERT INTO employees(full_name,email,phone,department,role)
    VALUES('$name','$email','$phone','$department','$role')");

    header("Location: employees.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
<title>Add Employee</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>

/* ===== BODY ===== */
body{
    background:#f4f6fb;
    font-family:Inter;
}

/* ===== CONTAINER ===== */
.container-box{
    max-width:700px;
    margin:40px auto;
    background:white;
    padding:25px;
    border-radius:15px;
    box-shadow:0 8px 20px rgba(0,0,0,0.05);
}

/* HEADER */
.header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:20px;
}

.header h3{
    font-weight:600;
}

/* INPUTS */
.form-control{
    border-radius:10px;
    padding:10px;
}

/* LABEL */
label{
    font-weight:500;
    margin-top:10px;
}

/* BUTTON */
.btn-save{
    background:#2563eb;
    color:white;
    padding:10px 15px;
    border:none;
    border-radius:10px;
    margin-top:15px;
    width:100%;
}

.btn-save:hover{
    background:#1e40af;
}

/* BACK LINK */
.back{
    text-decoration:none;
    color:#6b7280;
    font-size:14px;
}

.back:hover{
    color:#111827;
}

</style>

</head>

<body>

<div class="container-box">

    <!-- HEADER -->
    <div class="header">

        <h3> Add Employee</h3>

        <a href="employees.php" class="back">
            <i class="fa fa-arrow-left"></i> Back
        </a>

    </div>

    <!-- FORM -->
    <form method="POST">

        <label>Full Name</label>
        <input type="text" name="name" class="form-control" placeholder="Enter full name" required>

        <label>Email</label>
        <input type="email" name="email" class="form-control" placeholder="Enter email" required>

        <label>Phone</label>
        <input type="text" name="phone" class="form-control" placeholder="Enter phone">

        <label>Department</label>
        <input type="text" name="department" class="form-control" placeholder="e.g. HR, Nursing, Lab">

        <label>Role</label>
        <input type="text" name="role" class="form-control" placeholder="e.g. Doctor, Nurse">

        <button type="submit" name="save" class="btn-save">
            Save Employee
        </button>

    </form>

</div>

</body>
</html>