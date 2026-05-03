<?php
include '../dbConnection.php';
$id = (int)$_GET['id'];
$type = $_GET['type'];

if ($type == 'exp') {
    $conn->query("DELETE FROM resume_experience WHERE id=$id");
} else {
    $conn->query("DELETE FROM resume_education WHERE id=$id");
}

header("Location: resumeview.php");
?>