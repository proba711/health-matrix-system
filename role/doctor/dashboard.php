<?php
session_start();
include("../../config/db.php");

if(!isset($_SESSION['user'])){
    header("Location: ../../auth/login.php");
    exit;
}

if($_SESSION['user']['role'] != 'doctor'){
    header("Location: ../../auth/login.php");
    exit;
}

$today_appointments = $conn->query("SELECT COUNT(*) as t FROM appointments WHERE appointment_date = CURDATE()")->fetch_assoc()['t'] ?? 0;
$total_patients = $conn->query("SELECT COUNT(*) as t FROM patients")->fetch_assoc()['t'] ?? 0;
$my_appointments = $conn->query("SELECT COUNT(*) as t FROM appointments WHERE doctor = '".$_SESSION['user']['name']."'")->fetch_assoc()['t'] ?? 0;

$appointments = $conn->query("SELECT * FROM appointments WHERE appointment_date = CURDATE() ORDER BY appointment_time ASC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Doctor Dashboard - Health Matrix</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body {
            background: #f0f9ff;
            font-family: 'Segoe UI', sans-serif;
        }
        .sidebar {
            width: 260px;
            background: linear-gradient(180deg, #1e3a8a, #1e40af);
            min-height: 100vh;
            padding: 20px;
            color: white;
            position: fixed;
        }
        .sidebar a {
            color: #cbd5e1;
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
            border-left: 5px solid #3b82f6;
        }
        .appointment-table {
            background: white;
            border-radius: 15px;
            padding: 20px;
            margin-top: 20px;
        }
        .badge-pending { background: #fef3c7; color: #d97706; padding: 5px 12px; border-radius: 20px; }
        .badge-completed { background: #d1fae5; color: #059669; padding: 5px 12px; border-radius: 20px; }
        .badge-cancelled { background: #fee2e2; color: #dc2626; padding: 5px 12px; border-radius: 20px; }
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
    <a href="../../appointments/appointments.php"><i class="fas fa-calendar"></i> Appointments</a>
    <a href="../../patients/patients.php"><i class="fas fa-users"></i> Patients</a>
    <hr style="background: #cbd5e1;">
    <a href="../../auth/logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
</div>

<div class="content">
    <div class="topbar">
        <h4>Doctor Dashboard</h4>
        <div>
            <i class="fas fa-bell"></i>
            <span class="ms-3">Welcome, Dr. <?= $_SESSION['user']['name'] ?? 'Doctor' ?></span>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="stat-card">
                <h3><?= $today_appointments ?></h3>
                <small>Today's Appointments</small>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card">
                <h3><?= $total_patients ?></h3>
                <small>Total Patients</small>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card">
                <h3><?= $my_appointments ?></h3>
                <small>My Appointments</small>
            </div>
        </div>
    </div>

    <div class="appointment-table">
        <h5>Today's Appointments</h5>
        <table class="table table-hover mt-3">
            <thead>
                <tr>
                    <th>Patient</th>
                    <th>Time</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $appointments->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['patient_name'] ?></td>
                    <td><?= $row['appointment_time'] ?></td>
                    <td>
                        <span class="badge-<?= strtolower($row['status']) == 'pending' ? 'pending' : (strtolower($row['status']) == 'completed' ? 'completed' : 'cancelled') ?>">
                            <?= $row['status'] ?>
                        </span>
                    </td>
                    <td>
                        <a href="../../appointments/edit_appointment.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-warning">Update</a>
                    </td>
                </tr>
                <?php endwhile; ?>
                <?php if($appointments->num_rows == 0): ?>
                <tr><td colspan="4" class="text-center">No appointments today</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>