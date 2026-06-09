<?php
session_start();
include("../../config/db.php");

if(!isset($_SESSION['user'])){
    header("Location: ../../auth/login.php");
    exit;
}

if($_SESSION['user']['role'] != 'nurse'){
    header("Location: ../../auth/login.php");
    exit;
}

$total_patients = $conn->query("SELECT COUNT(*) as t FROM patients")->fetch_assoc()['t'] ?? 0;
$admitted = $conn->query("SELECT COUNT(*) as t FROM patients WHERE status='Admitted'")->fetch_assoc()['t'] ?? 0;
$waiting = $conn->query("SELECT COUNT(*) as t FROM patients WHERE status='Waiting'")->fetch_assoc()['t'] ?? 0;

$patients = $conn->query("SELECT * FROM patients ORDER BY id DESC LIMIT 10");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Nurse Dashboard - Health Matrix</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body {
            background: #f0fdf4;
            font-family: 'Segoe UI', sans-serif;
        }
        .sidebar {
            width: 260px;
            background: linear-gradient(180deg, #065f46, #047857);
            min-height: 100vh;
            padding: 20px;
            color: white;
            position: fixed;
        }
        .sidebar a {
            color: #a7f3d0;
            display: block;
            padding: 12px;
            text-decoration: none;
            border-radius: 8px;
            margin-bottom: 5px;
        }
        .sidebar a:hover, .sidebar a.active {
            background: rgba(255,255,255,0.1);
            color: white;
        }
        .content {
            margin-left: 280px;
            padding: 20px;
        }
        .stat-card {
            background: white;
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            border-left: 5px solid #10b981;
        }
        .table-box {
            background: white;
            border-radius: 15px;
            padding: 20px;
            margin-top: 20px;
        }
        .topbar {
            background: white;
            border-radius: 15px;
            padding: 15px 20px;
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
    </style>
</head>
<body>

<div class="sidebar">
    <h3 class="mb-4">Health Matrix</h3>
    <a href="#" class="active"><i class="fas fa-home"></i> Dashboard</a>
    <a href="../../patients/patients.php"><i class="fas fa-users"></i> Patients</a>
    <a href="../../appointments/appointments.php"><i class="fas fa-calendar"></i> Appointments</a>
    <hr>
    <a href="../../auth/logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
</div>

<div class="content">
    <div class="topbar">
        <h4>Nurse Dashboard</h4>
        <div>Welcome, <?= $_SESSION['user']['name'] ?? 'Nurse' ?></div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="stat-card"><h3><?= $total_patients ?></h3><small>Total Patients</small></div>
        </div>
        <div class="col-md-4">
            <div class="stat-card"><h3><?= $admitted ?></h3><small>Admitted</small></div>
        </div>
        <div class="col-md-4">
            <div class="stat-card"><h3><?= $waiting ?></h3><small>Waiting</small></div>
        </div>
    </div>

    <div class="table-box">
        <h5>Recent Patients</h5>
        <table class="table table-hover mt-3">
            <thead>
                <tr>
                    <th>MR</th>
                    <th>Name</th>
                    <th>Department</th>
                    <th>Doctor</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $patients->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['mr_number'] ?></td>
                    <td><?= $row['full_name'] ?></td>
                    <td><?= $row['department'] ?></td>
                    <td><?= $row['doctor'] ?></td>
                    <td><?= $row['status'] ?? 'Waiting' ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>