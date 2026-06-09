<?php
include("../config/db.php");
session_start();

if(!isset($_SESSION['user'])){
    header("Location: ../auth/login.php");
    exit;
}

$id = $_GET['id'];

if(isset($_POST['update'])){
    $status = $_POST['status'];
    $conn->query("UPDATE appointments SET status='$status' WHERE id=$id");
    header("Location: appointments.php");
}

$result = $conn->query("SELECT * FROM appointments WHERE id=$id");
$row = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Appointment</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5" style="max-width:500px;">
        <div class="card shadow">
            <div class="card-header bg-warning">
                <h4>✏️ Edit Appointment Status</h4>
            </div>
            <div class="card-body">
                <form method="POST">
                    <label>Patient: <strong><?= $row['patient_name'] ?></strong></label>
                    <select name="status" class="form-control mt-2" required>
                        <option value="Pending" <?= $row['status']=='Pending' ? 'selected' : '' ?>>Pending</option>
                        <option value="Completed" <?= $row['status']=='Completed' ? 'selected' : '' ?>>Completed</option>
                        <option value="Cancelled" <?= $row['status']=='Cancelled' ? 'selected' : '' ?>>Cancelled</option>
                    </select>
                    <button type="submit" name="update" class="btn btn-warning w-100 mt-3">Update Status</button>
                    <a href="appointments.php" class="btn btn-secondary w-100 mt-2">Back</a>
                </form>
            </div>
        </div>
    </div>
</body>
</html>