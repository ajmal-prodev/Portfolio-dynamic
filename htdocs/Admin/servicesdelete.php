<?php
include '../dbConnection.php';
$id = (int)$_GET['id'];
$conn->query("DELETE FROM services WHERE id=$id");
header("Location: servicesview.php");
?>