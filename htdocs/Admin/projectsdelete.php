<?php
include '../dbConnection.php';
$id = (int)$_GET['id'];
$res = $conn->query("SELECT image FROM projects WHERE id=$id");
if($row = $res->fetch_assoc()){
    if(!empty($row['image']) && file_exists("uploads/".$row['image'])) unlink("uploads/".$row['image']);
}
$conn->query("DELETE FROM projects WHERE id=$id");
header("Location: projectsview.php");
?>