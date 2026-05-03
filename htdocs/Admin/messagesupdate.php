<?php 
define('PAGE','MESSAGES'); 
define('TITLE','Update Message');
include('includes/header.php');
include('../dbConnection.php');


if(!isset($_SESSION['is_adminlogin'])){
    echo "<script>location.href='../index.php'</script>";
}

$msg = "";
$id = isset($_GET['id']) ? $_GET['id'] : (isset($_POST['id']) ? $_POST['id'] : 0);

// Fetch message data
$sql = "SELECT * FROM contact_messages WHERE id='$id'";
$result = $conn->query($sql);
if($result->num_rows == 1) {
    $row = $result->fetch_assoc();
} else {
    echo "<script>location.href='messages.php';</script>";
    exit();
}

if(isset($_POST['update'])) {
    $name = mysqli_real_escape_string($conn, trim($_POST['name']));
    $email = mysqli_real_escape_string($conn, trim($_POST['email']));
    $message = mysqli_real_escape_string($conn, trim($_POST['message']));
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    
    // Validation
    $errors = [];
    if(empty($name)) $errors[] = "Name is required";
    if(empty($email)) $errors[] = "Email is required";
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Invalid email format";
    if(empty($message)) $errors[] = "Message is required";
    
    if(empty($errors)) {
        $sql = "UPDATE contact_messages SET 
                name='$name', 
                email='$email', 
                message='$message', 
                status='$status' 
                WHERE id='$id'";
        
        if($conn->query($sql)) {
            $_SESSION['success_msg'] = "Message updated successfully!";
            echo "<script>location.href='messages.php';</script>";
            exit();
        } else {
            $msg = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Error!</strong> Failed to update message: ' . $conn->error . '
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>';
        }
    } else {
        $errorList = implode("<br>", $errors);
        $msg = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Validation Errors!</strong><br>' . $errorList . '
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
    }
}
?>

<div class="col-sm-9 col-md-10 maincontentheight px-2 py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3">Update Message</h1>
        <div>
            <a href="messagesview.php?id=<?php echo $row['id']; ?>" class="btn btn-info">
                <i class="fas fa-eye"></i> View
            </a>
            <a href="messages.php" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to Messages
            </a>
        </div>
    </div>

    <?php echo $msg; ?>

    <div class="card shadow">
        <div class="card-header bg-warning text-dark">
            <h5 class="mb-0"><i class="fas fa-edit"></i> Edit Message Information</h5>
        </div>
        <div class="card-body">
            <form method="POST" action="" id="updateMessageForm">
                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                
                <div class="mb-3">
                    <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="name" name="name" 
                           value="<?php echo htmlspecialchars($row['name']); ?>" required>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                    <input type="email" class="form-control" id="email" name="email" 
                           value="<?php echo htmlspecialchars($row['email']); ?>" required>
                </div>

                <div class="mb-3">
                    <label for="message" class="form-label">Message <span class="text-danger">*</span></label>
                    <textarea class="form-control" id="message" name="message" rows="6" required><?php echo htmlspecialchars($row['message']); ?></textarea>
                </div>

                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-select" id="status" name="status">
                        <option value="unread" <?php echo ($row['status'] == 'unread') ? 'selected' : ''; ?>>Unread</option>
                        <option value="read" <?php echo ($row['status'] == 'read') ? 'selected' : ''; ?>>Read</option>
                        <option value="replied" <?php echo ($row['status'] == 'replied') ? 'selected' : ''; ?>>Replied</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Created At:</label>
                    <input type="text" class="form-control" value="<?php echo $row['created_at']; ?>" readonly disabled>
                </div>

                <div class="text-center">
                    <button type="submit" name="update" class="btn btn-primary btn-lg px-4">
                        <i class="fas fa-save"></i> Update Message
                    </button>
                    <button type="reset" class="btn btn-secondary btn-lg px-4">
                        <i class="fas fa-undo"></i> Reset
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.getElementById('updateMessageForm').addEventListener('submit', function(e) {
    var name = document.getElementById('name').value.trim();
    var email = document.getElementById('email').value.trim();
    var message = document.getElementById('message').value.trim();
    
    if(name === '') {
        e.preventDefault();
        alert('Please enter the name');
        return false;
    }
    
    if(email === '') {
        e.preventDefault();
        alert('Please enter the email');
        return false;
    }
    
    var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if(!emailPattern.test(email)) {
        e.preventDefault();
        alert('Please enter a valid email address');
        return false;
    }
    
    if(message === '') {
        e.preventDefault();
        alert('Please enter the message');
        return false;
    }
});
</script>

<?php include('includes/footer.php'); ?>