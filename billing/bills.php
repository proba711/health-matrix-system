<?php
include("../config/db.php");

$res = $conn->query("SELECT * FROM bills ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
<title>Bills - Health Matrix</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body{
    background:#f5f7ff;
    font-family:Arial;
}

.container-box{
    background:#fff;
    padding:20px;
    border-radius:12px;
    margin-top:20px;
    box-shadow:0 5px 15px rgba(0,0,0,0.05);
}

.badge-paid{
    background:green;
}

.badge-pending{
    background:orange;
}
</style>

</head>

<body>

<div class="container p-4">

<h2>🧾 Bills Module</h2>

<a href="add_bill.php" class="btn btn-primary mb-3">+ Create Bill</a>

<div class="container-box">

<table class="table table-hover">
<thead class="table-dark">
<tr>
<th>Patient</th>
<th>Total</th>
<th>Status</th>
<th>Action</th>
</tr>
</thead>

<tbody>

<?php while($row = $res->fetch_assoc()){ ?>

<tr>
<td><?= $row['patient_name'] ?></td>

<td>
<?= number_format($row['total'],2) ?>
</td>

<td>

<?php if($row['status'] == "paid"){ ?>
<span class="badge bg-success">Paid</span>
<?php } else { ?>
<span class="badge bg-warning text-dark">Pending</span>
<?php } ?>

</td>

<td>
<a href="view_bill.php?id=<?= $row['id'] ?>" class="btn btn-info btn-sm">View</a>
</td>

</tr>

<?php } ?>

</tbody>
</table>

</div>

</div>

</body>
</html>