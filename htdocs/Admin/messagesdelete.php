<?php 
include('../dbConnection.php');


if(!isset($_SESSION['is_adminlogin'])){
    echo "<script>location.href='../index.php'</script>";
    exit();
}

if(isset($_GET['id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);
    
    // Optional: Check if message exists before deleting
    $check_sql = "SELECT id FROM contact_messages WHERE id='$id'";
    $check_result = $conn->query($check_sql);
    
    if($check_result->num_rows == 1) {
        $sql = "DELETE FROM contact_messages WHERE id='$id'";
        
        if($conn->query($sql)) {
            $_SESSION['delete_msg'] = "Message deleted successfully!";
        } else {
            $_SESSION['delete_msg'] = "Failed to delete message: " . $conn->error;
        }
    } else {
        $_SESSION['delete_msg'] = "Message not found!";
    }
}

// Redirect back to messages page
echo "<script>location.href='messages.php';</script>";
exit();
?>