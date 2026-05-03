<?php
include '../dbConnection.php';
$id = (int)$_GET['id'];

$res = $conn->query("SELECT image FROM about WHERE id=$id");
if($row = $res->fetch_assoc()){
    if(file_exists("uploads/".$row['image'])) unlink("uploads/".$row['image']);
}

$conn->query("DELETE FROM about WHERE id=$id");
header("Location: aboutview.php");
?>