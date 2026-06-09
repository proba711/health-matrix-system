<?php
session_start();
include("../config/db.php");

if(isset($_POST['login'])){

    $email = $_POST['email'];
    $password = md5($_POST['password']);

    $result = $conn->query("SELECT * FROM users WHERE email='$email' AND password='$password'");

    if($result->num_rows > 0){

        $user = $result->fetch_assoc();

        if($user['status'] != 'active'){
            $error = "Your account is pending approval by administrator!";
        } else {
            $_SESSION['user'] = $user;

            if($user['role'] == "admin"){
                header("Location: ../admin/dashboard.php");
                exit;
            }
            elseif($user['role'] == "doctor"){
                header("Location: ../role/doctor/dashboard.php");
                exit;
            }
            elseif($user['role'] == "nurse"){
                header("Location: ../role/nurse/dashboard.php");
                exit;
            }
            elseif($user['role'] == "cashier"){
                header("Location: ../role/cashier/dashboard.php");
                exit;
            }
        }

    }else{
        $error = "Invalid Email or Password!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Health Matrix</title>
    
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

        .login-container {
            position: relative;
            z-index: 1;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .login-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 40px 35px;
            width: 100%;
            max-width: 450px;
            box-shadow: 0 25px 55px rgba(0, 0, 0, 0.3);
            transition: transform 0.3s;
            animation: fadeInUp 0.6s ease-out;
        }

        .login-card:hover {
            transform: translateY(-5px);
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .logo {
            text-align: center;
            margin-bottom: 30px;
        }

        .logo .icon {
            font-size: 60px;
            color: #2563eb;
            background: white;
            padding: 15px;
            border-radius: 50%;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            display: inline-block;
        }

        .logo h2 {
            margin-top: 15px;
            font-weight: 700;
            color: #1e3a8a;
        }

        .logo p {
            color: #6b7280;
            font-size: 14px;
        }

        .input-group {
            margin-bottom: 20px;
        }

        .input-group input {
            width: 100%;
            padding: 12px;
            font-size: 15px;
            border: none;
            background: #f3f4f6;
            border-radius: 10px;
            outline: none;
        }

        .input-group input:focus {
            background: #eef2ff;
        }

        .btn-login {
            background: linear-gradient(135deg, #2563eb 0%, #1e3a8a 100%);
            border: none;
            padding: 12px;
            font-weight: 600;
            font-size: 16px;
            border-radius: 10px;
            width: 100%;
            color: white;
            cursor: pointer;
            transition: all 0.3s;
        }

        .btn-login:hover {
            transform: scale(1.02);
            background: linear-gradient(135deg, #1e40af 0%, #1e3a8a 100%);
        }

        .alert-error {
            background: #fee2e2;
            color: #dc2626;
            border: none;
            border-radius: 10px;
            padding: 12px;
            font-size: 14px;
            text-align: center;
            margin-bottom: 15px;
        }

        .footer-text {
            text-align: center;
            margin-top: 25px;
            font-size: 13px;
            color: #6b7280;
        }

        .register-link {
            text-align: center;
            margin-top: 15px;
            font-size: 13px;
        }

        .register-link a {
            color: #2563eb;
            text-decoration: none;
        }

        .register-link a:hover {
            text-decoration: underline;
        }

        @media (max-width: 480px) {
            .login-card {
                padding: 30px 20px;
                margin: 20px;
            }
        }
    </style>
</head>

<body>

<div class="login-container">
    <div class="login-card">
        
        <div class="logo">
            <div class="icon">🏥</div>
            <h2>Health Matrix</h2>
            <p>Hospital Management System</p>
        </div>

        <?php if(isset($error)): ?>
            <div class="alert-error">
                ⚠️ <?php echo $error; ?>
            </div>
        <?php endif; ?>

        <form method="POST">
            <div class="input-group">
                <input type="email" name="email" placeholder="Email Address" required>
            </div>

            <div class="input-group">
                <input type="password" name="password" placeholder="Password" required>
            </div>

            <button type="submit" name="login" class="btn-login">
                Login
            </button>

            <div class="footer-text">
                Secure Access Only
            </div>
            
            <div class="register-link">
                <a href="register.php">Don't have an account? Register here</a>
            </div>
        </form>

    </div>
</div>

</body>
</html>