<?php
include("../config/db.php");

$id = $_GET['id'];
$conn->query("DELETE FROM appointments WHERE id=$id");
header("Location: appointments.php");
?>