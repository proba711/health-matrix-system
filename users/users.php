<?php
session_start();
include("../config/db.php");

error_reporting(E_ALL);
ini_set('display_errors', 1);

if(!isset($_SESSION['user'])){
    header("Location: ../auth/login.php");
    exit;
}

// Check if user is admin
$current_user = $_SESSION['user'];
$is_admin = ($current_user['role'] == 'admin');

if(!$is_admin){
    echo "<div class='alert alert-danger'>Access Denied! Only Admin can access this page.</div>";
    exit;
}

// Handle Add User
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_user'])){
    $fullname = mysqli_real_escape_string($conn, $_POST['fullname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = md5('default123');
    $role = $_POST['role'];
    $status = 'active';
    
    $check = $conn->query("SELECT id FROM users WHERE email = '$email'");
    if($check->num_rows == 0){
        $conn->query("INSERT INTO users (fullname, email, password, role, status) VALUES ('$fullname', '$email', '$password', '$role', '$status')");
        $success = "✅ User added successfully! Default password: default123";
    } else {
        $error = "❌ Email already exists!";
    }
}

// Handle Activate/Deactivate/Delete/Reset
if(isset($_GET['activate'])){
    $id = (int)$_GET['activate'];
    $conn->query("UPDATE users SET status = 'active' WHERE id = $id");
    $success = "✅ User activated!";
}
if(isset($_GET['deactivate'])){
    $id = (int)$_GET['deactivate'];
    $conn->query("UPDATE users SET status = 'inactive' WHERE id = $id");
    $success = "⛔ User deactivated!";
}
if(isset($_GET['reset'])){
    $id = (int)$_GET['reset'];
    $conn->query("UPDATE users SET password = md5('default123') WHERE id = $id");
    $success = "🔑 Password reset to default123";
}
if(isset($_GET['delete'])){
    $id = (int)$_GET['delete'];
    if($id != $current_user['id']){
        $conn->query("DELETE FROM users WHERE id = $id");
        $success = "🗑️ User deleted!";
    } else {
        $error = "❌ Cannot delete yourself!";
    }
}

// Get all users
$users_result = $conn->query("SELECT id, fullname, email, role, status, created_at FROM users ORDER BY id DESC");
$users = [];
while($row = $users_result->fetch_assoc()){
    $users[] = $row;
}

$total = count($users);
$active = 0;
$inactive = 0;
foreach($users as $u){
    if($u['status'] == 'active') $active++;
    else $inactive++;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Management - Health Matrix</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body { background: #f5f7ff; font-family: Inter; }
        .layout { display: flex; gap: 20px; padding: 20px; }
        .sidebar-card {
            width: 260px;
            background: linear-gradient(180deg,#1e2a78,#2b3bbd);
            border-radius: 18px;
            padding: 15px;
            color: white;
            height: fit-content;
            position: sticky;
            top: 20px;
        }
        .sidebar-card a {
            display: block;
            padding: 10px;
            color: #dbe3ff;
            text-decoration: none;
            border-radius: 8px;
        }
        .sidebar-card a:hover, .sidebar-card a.active {
            background: rgba(255,255,255,0.15);
            color: white;
        }
        .main { flex: 1; }
        .topbar {
            background: #fff;
            padding: 14px;
            border-radius: 14px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        .card-box {
            background: #fff;
            padding: 15px;
            border-radius: 14px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        }
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
            margin-bottom: 20px;
        }
        .table-box {
            background: #fff;
            padding: 15px;
            border-radius: 14px;
            margin-top: 20px;
        }
        .btn-sm { padding: 4px 8px; font-size: 12px; margin: 2px; }
        .status-active { background: #d4edda; color: #155724; padding: 3px 8px; border-radius: 20px; font-size: 12px; }
        .status-inactive { background: #f8d7da; color: #721c24; padding: 3px 8px; border-radius: 20px; font-size: 12px; }
        .add-form {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 14px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<div class="layout">

    <div class="sidebar-card">
        <h4>Health Matrix</h4>
        <a href="../dashboard.php"><i class="fa fa-home"></i> Dashboard</a>
        <a href="../hrm/employees.php"><i class="fa fa-user-md"></i> HRM</a>
        <a href="../patients/patients.php"><i class="fa fa-user"></i> Patients</a>
        <a href="../appointments/appointments.php"><i class="fa fa-calendar"></i> Appointments</a>
        <a href="../billing/bills.php"><i class="fa fa-credit-card"></i> Billing</a>
        <a href="users.php" class="active"><i class="fa fa-users"></i> Users</a>
        <hr style="background:white;">
        <a href="../auth/logout.php" style="color:#ffb4b4;"><i class="fa fa-sign-out"></i> Logout</a>
    </div>

    <div class="main">

        <div class="topbar">
            <h5>👑 User Management</h5>
            <div><i class="fa fa-bell"></i></div>
        </div>

        <div class="stats-grid">
            <div class="card-box"><h3><?= $total ?></h3><small>Total Users</small></div>
            <div class="card-box"><h3><?= $active ?></h3><small>Active</small></div>
            <div class="card-box"><h3><?= $inactive ?></h3><small>Inactive</small></div>
        </div>

        <?php if(isset($success)): ?>
            <div class="alert alert-success"><?= $success ?></div>
        <?php endif; ?>
        <?php if(isset($error)): ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>

        <div class="add-form">
            <h5><i class="fa fa-plus-circle"></i> Add New User</h5>
            <form method="POST">
                <div class="row g-2">
                    <div class="col-md-4">
                        <input type="text" name="fullname" class="form-control" placeholder="Full Name" required>
                    </div>
                    <div class="col-md-4">
                        <input type="email" name="email" class="form-control" placeholder="Email" required>
                    </div>
                    <div class="col-md-3">
                        <select name="role" class="form-select">
                            <option value="patient">Patient</option>
                            <option value="doctor">Doctor</option>
                            <option value="staff">Staff</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                    <div class="col-md-1">
                        <button type="submit" name="add_user" class="btn btn-success w-100">Add</button>
                    </div>
                </div>
                <small class="text-muted">⚠️ Default password: <strong>default123</strong></small>
            </form>
        </div>

        <div class="table-box">
            <h5><i class="fa fa-users"></i> System Users</h5>
            <input type="text" id="searchInput" class="form-control mb-3 w-50" placeholder="🔍 Search users...">
            
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th><th>Full Name</th><th>Email</th><th>Role</th><th>Status</th><th>Registered</th><th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="usersTable">
                        <?php foreach($users as $user): ?>
                        <tr>
                            <td><?= $user['id'] ?></td>
                            <td><?= htmlspecialchars($user['fullname']) ?></td>
                            <td><?= htmlspecialchars($user['email']) ?></td>
                            <td><?= ucfirst($user['role']) ?></td>
                            <td>
                                <span class="status-<?= $user['status'] ?>">
                                    <?= $user['status'] == 'active' ? '✅ Active' : '❌ Inactive' ?>
                                </span>
                            </td>
                            <td><?= date('d/m/Y', strtotime($user['created_at'])) ?></td>
                            <td>
                                <?php if($user['id'] != $current_user['id']): ?>
                                    <?php if($user['status'] == 'active'): ?>
                                        <a href="?deactivate=<?= $user['id'] ?>" class="btn btn-warning btn-sm" onclick="return confirm('Deactivate?')">Deactivate</a>
                                    <?php else: ?>
                                        <a href="?activate=<?= $user['id'] ?>" class="btn btn-success btn-sm" onclick="return confirm('Activate?')">Activate</a>
                                    <?php endif; ?>
                                    <a href="?reset=<?= $user['id'] ?>" class="btn btn-info btn-sm" onclick="return confirm('Reset password?')">Reset</a>
                                    <a href="?delete=<?= $user['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Delete user?')">Delete</a>
                                <?php else: ?>
                                    <span class="badge bg-secondary">You</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

<script>
    document.getElementById('searchInput').addEventListener('keyup', function() {
        let value = this.value.toLowerCase();
        let rows = document.querySelectorAll('#usersTable tr');
        rows.forEach(row => {
            let text = row.textContent.toLowerCase();
            row.style.display = text.includes(value) ? '' : 'none';
        });
    });
</script>

</body>
</html>