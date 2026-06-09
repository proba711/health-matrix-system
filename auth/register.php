<?php
session_start();
include("../config/db.php");

if(isset($_POST['register'])){
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = md5($_POST['password']);
    $role = $_POST['role'];
    
    $check = $conn->query("SELECT * FROM users WHERE email='$email'");
    if($check->num_rows > 0){
        $error = "Email already exists!";
    } else {
        $conn->query("INSERT INTO users (name, email, password, role, status) 
                      VALUES ('$name', '$email', '$password', '$role', 'pending')");
        $success = "Registration successful! Wait for admin approval.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register - Health Matrix</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            min-height: 100vh;
            background: url('../assets/images/istockphoto.jpg') no-repeat center center/cover;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            position: relative;
        }
        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.65);
            z-index: 0;
        }
        .register-container {
            position: relative;
            z-index: 1;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .register-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 40px 35px;
            width: 100%;
            max-width: 500px;
            box-shadow: 0 25px 55px rgba(0, 0, 0, 0.3);
        }
        .register-card h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #1e3a8a;
        }
        .form-control {
            width: 100%;
            margin-bottom: 15px;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 10px;
            font-size: 14px;
        }
        .btn-register {
            background: linear-gradient(135deg, #2563eb 0%, #1e3a8a 100%);
            color: white;
            padding: 12px;
            border: none;
            border-radius: 10px;
            width: 100%;
            font-weight: 600;
            cursor: pointer;
        }
        .login-link {
            text-align: center;
            margin-top: 20px;
        }
        .login-link a {
            color: #2563eb;
            text-decoration: none;
        }
        .alert {
            padding: 10px;
            border-radius: 10px;
            margin-bottom: 20px;
            text-align: center;
        }
        .alert-error {
            background: #fee2e2;
            color: #dc2626;
        }
        .alert-success {
            background: #d1fae5;
            color: #059669;
        }
    </style>
</head>
<body>
<div class="register-container">
    <div class="register-card">
        <h2>Register New Account</h2>
        
        <?php if(isset($error)): ?>
            <div class="alert alert-error"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <?php if(isset($success)): ?>
            <div class="alert alert-success"><?php echo $success; ?></div>
        <?php endif; ?>
        
        <form method="POST">
            <input type="text" name="name" class="form-control" placeholder="Full Name" required>
            <input type="email" name="email" class="form-control" placeholder="Email Address" required>
            <input type="password" name="password" class="form-control" placeholder="Password" required>
            <select name="role" class="form-control" required>
                <option value="doctor">Doctor</option>
                <option value="nurse">Nurse</option>
                <option value="cashier">Cashier</option>
            </select>
            <button type="submit" name="register" class="btn-register">Register</button>
        </form>
        
        <div class="login-link">
            <a href="login.php">Already have an account? Login here</a>
        </div>
    </div>
</div>
</body>
</html>