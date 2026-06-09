<?php
session_start();
include("../../config/db.php");

if(!isset($_SESSION['user'])){
    header("Location: ../../auth/login.php");
    exit;
}

if($_SESSION['user']['role'] != 'cashier'){
    header("Location: ../../auth/login.php");
    exit;
}

$total_bills = $conn->query("SELECT COUNT(*) as t FROM bills")->fetch_assoc()['t'] ?? 0;
$paid = $conn->query("SELECT COUNT(*) as t FROM bills WHERE status='paid'")->fetch_assoc()['t'] ?? 0;
$pending = $conn->query("SELECT COUNT(*) as t FROM bills WHERE status='pending'")->fetch_assoc()['t'] ?? 0;
$revenue = $conn->query("SELECT SUM(total) as t FROM bills WHERE status='paid'")->fetch_assoc()['t'] ?? 0;

$bills = $conn->query("SELECT * FROM bills ORDER BY id DESC LIMIT 10");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Cashier Dashboard - Health Matrix</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body {
            background: #fefce8;
            font-family: 'Segoe UI', sans-serif;
        }
        .sidebar {
            width: 260px;
            background: linear-gradient(180deg, #854d0e, #a16207);
            min-height: 100vh;
            padding: 20px;
            color: white;
            position: fixed;
        }
        .sidebar a {
            color: #fef08a;
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
            border-left: 5px solid #eab308;
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
        .badge-paid { background: #d1fae5; color: #059669; padding: 5px 12px; border-radius: 20px; }
        .badge-pending { background: #fef3c7; color: #d97706; padding: 5px 12px; border-radius: 20px; }
    </style>
</head>
<body>

<div class="sidebar">
    <h3 class="mb-4">Health Matrix</h3>
    <a href="#" class="active"><i class="fas fa-home"></i> Dashboard</a>
    <a href="../../billing/bills.php"><i class="fas fa-credit-card"></i> Billing</a>
    <hr>
    <a href="../../auth/logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
</div>

<div class="content">
    <div class="topbar">
        <h4>Cashier Dashboard</h4>
        <div>Welcome, <?= $_SESSION['user']['name'] ?? 'Cashier' ?></div>
    </div>

    <div class="row">
        <div class="col-md-3">
            <div class="stat-card"><h3><?= $total_bills ?></h3><small>Total Bills</small></div>
        </div>
        <div class="col-md-3">
            <div class="stat-card"><h3><?= $paid ?></h3><small>Paid</small></div>
        </div>
        <div class="col-md-3">
            <div class="stat-card"><h3><?= $pending ?></h3><small>Pending</small></div>
        </div>
        <div class="col-md-3">
            <div class="stat-card"><h3>Tsh <?= number_format($revenue) ?></h3><small>Revenue</small></div>
        </div>
    </div>

    <div class="table-box">
        <h5>Recent Bills</h5>
        <table class="table table-hover mt-3">
            <thead>
                <tr>
                    <th>Patient</th>
                    <th>Service</th>
                    <th>Amount</th>
                    <th>Total</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $bills->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['patient_name'] ?></td>
                    <td><?= $row['service'] ?></td>
                    <td>Tsh <?= number_format($row['amount']) ?></td>
                    <td>Tsh <?= number_format($row['total']) ?></td>
                    <td><span class="badge-<?= $row['status'] ?>"><?= ucfirst($row['status']) ?></span></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>