<?php 
define('PAGE','MESSAGES'); 
define('TITLE','View Message');
include('includes/header.php');
include('../dbConnection.php');


if(!isset($_SESSION['is_adminlogin'])){
    echo "<script>location.href='../index.php'</script>";
}

$id = isset($_GET['id']) ? $_GET['id'] : 0;

// Fetch message data
$sql = "SELECT * FROM contact_messages WHERE id='$id'";
$result = $conn->query($sql);
if($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    
    // Mark as read if it's unread
    if($row['status'] == 'unread') {
        $update_sql = "UPDATE contact_messages SET status='read' WHERE id='$id'";
        $conn->query($update_sql);
        $row['status'] = 'read';
    }
} else {
    echo "<script>location.href='messages.php';</script>";
    exit();
}

$statusClass = '';
if($row['status'] == 'unread') $statusClass = 'danger';
if($row['status'] == 'read') $statusClass = 'warning';
if($row['status'] == 'replied') $statusClass = 'success';
?>

<div class="col-sm-9 col-md-10 maincontentheight px-2 py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3">Message Details</h1>
        <div>
            <a href="messagesupdate.php?id=<?php echo $row['id']; ?>" class="btn btn-primary">
                <i class="fas fa-edit"></i> Edit
            </a>
            <button onclick="deleteMessage(<?php echo $row['id']; ?>)" class="btn btn-danger">
                <i class="fas fa-trash"></i> Delete
            </button>
            <a href="messages.php" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>
    </div>

    <div class="card shadow">
        <div class="card-header bg-info text-white">
            <h5 class="mb-0">
                <i class="fas fa-envelope"></i> Message from <?php echo htmlspecialchars($row['name']); ?>
            </h5>
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-3 fw-bold">Message ID:</div>
                <div class="col-md-9">#<?php echo $row['id']; ?></div>
            </div>
            <div class="row mb-3">
                <div class="col-md-3 fw-bold">Name:</div>
                <div class="col-md-9"><?php echo htmlspecialchars($row['name']); ?></div>
            </div>
            <div class="row mb-3">
                <div class="col-md-3 fw-bold">Email:</div>
                <div class="col-md-9">
                    <a href="mailto:<?php echo $row['email']; ?>"><?php echo htmlspecialchars($row['email']); ?></a>
                    <button onclick="copyToClipboard('<?php echo $row['email']; ?>')" class="btn btn-sm btn-secondary ms-2">
                        <i class="fas fa-copy"></i> Copy
                    </button>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-3 fw-bold">Status:</div>
                <div class="col-md-9">
                    <span class="badge bg-<?php echo $statusClass; ?> p-2">
                        <?php echo ucfirst($row['status']); ?>
                    </span>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-3 fw-bold">Received:</div>
                <div class="col-md-9"><?php echo date('F d, Y \a\t h:i A', strtotime($row['created_at'])); ?></div>
            </div>
            <div class="row mb-3">
                <div class="col-md-3 fw-bold">Message:</div>
                <div class="col-md-9">
                    <div class="p-3 bg-light rounded" style="border-left: 4px solid #2ea3f2;">
                        <?php echo nl2br(htmlspecialchars($row['message'])); ?>
                    </div>
                </div>
            </div>

            <hr>

            <div class="mt-4">
                <h5><i class="fas fa-reply"></i> Quick Reply</h5>
                <div class="input-group mt-2">
                    <input type="text" id="replyEmail" class="form-control" value="<?php echo $row['email']; ?>" readonly>
                    <button onclick="openMailClient('<?php echo $row['name']; ?>', '<?php echo $row['email']; ?>')" class="btn btn-success">
                        <i class="fas fa-envelope"></i> Compose Email
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(function() {
        alert('Email copied to clipboard: ' + text);
    }, function() {
        alert('Failed to copy email');
    });
}

function openMailClient(name, email) {
    var subject = 'Re: Contact Form Message from ' + name;
    var body = "Dear " + name + ",\n\nThank you for your message. We will get back to you soon.\n\nBest regards,\nAdministrator\n\n--- Original Message ---\n<?php echo addslashes($row['message']); ?>";
    window.location.href = 'mailto:' + email + '?subject=' + encodeURIComponent(subject) + '&body=' + encodeURIComponent(body);
}

function deleteMessage(id) {
    if(confirm('Are you sure you want to delete this message? This action cannot be undone!')) {
        window.location.href = 'messagesdelete.php?id=' + id;
    }
}
</script>

<?php include('includes/footer.php'); ?>