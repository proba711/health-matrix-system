<?php
include("../config/db.php");

error_reporting(E_ALL);
ini_set('display_errors', 1);

if(isset($_POST['save'])){

    // =========================
    // GET INPUTS SAFELY
    // =========================
    $patient = trim($_POST['patient']);
    $service = trim($_POST['service']);
    $amount = floatval($_POST['amount']);
    $discount = floatval($_POST['discount']);

    // =========================
    // VALIDATION (IMPORTANT)
    // =========================
    if($patient == "" || $service == ""){
        die("Patient and Service are required!");
    }

    if($amount < 0){
        $amount = 0;
    }

    if($discount < 0){
        $discount = 0;
    }

    // =========================
    // BUSINESS LOGIC (NO NEGATIVE TOTAL)
    // =========================
    if($discount > $amount){
        $discount = $amount;
    }

    $total = $amount - $discount;

    if($total < 0){
        $total = 0;
    }

    // =========================
    // INSERT INTO DATABASE
    // =========================
    $sql = "INSERT INTO bills 
    (patient_name, service, amount, discount, total, status) 
    VALUES 
    ('$patient', '$service', '$amount', '$discount', '$total', 'pending')";

    if($conn->query($sql)){
        header("Location: bills.php");
        exit;
    } else {
        die("Error inserting bill: " . $conn->error);
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Bill - Health Matrix</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body{
            background:#f5f7ff;
            font-family:Arial;
        }

        .container-box{
            width:500px;
            margin:60px auto;
            background:#fff;
            padding:25px;
            border-radius:14px;
            box-shadow:0 10px 25px rgba(0,0,0,0.08);
        }

        .title{
            text-align:center;
            font-weight:600;
            margin-bottom:20px;
        }

        input{
            margin-bottom:12px;
        }

        .btn-save{
            width:100%;
            padding:10px;
            background:#2563eb;
            color:white;
            border:none;
            border-radius:10px;
            font-weight:600;
        }

        .btn-save:hover{
            background:#1e40af;
        }
    </style>
</head>

<body>

<div class="container-box">

    <div class="title">🧾 Create New Bill</div>

    <form method="POST">

        <label>Patient Name</label>
        <input type="text" name="patient" class="form-control" required>

        <label>Service</label>
        <input type="text" name="service" class="form-control" required>

        <label>Amount</label>
        <input type="number" name="amount" class="form-control" step="0.01" required>

        <label>Discount</label>
        <input type="number" name="discount" class="form-control" step="0.01" value="0">

        <button type="submit" name="save" class="btn-save mt-2">
            Save Bill
        </button>

    </form>

</div>

</body>
</html>