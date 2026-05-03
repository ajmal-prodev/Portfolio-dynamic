<?php
include '../dbConnection.php';
$id = $_GET['id'];

// Optional: Delete physical files from folder too
$res = $conn->query("SELECT image, resume FROM home WHERE id=$id");
$files = $res->fetch_assoc();
unlink("uploads/".$files['image']);
unlink("uploads/".$files['resume']);

$conn->query("DELETE FROM home WHERE id=$id");
header("Location: homeview.php");
?>