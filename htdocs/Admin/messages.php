<?php 
define('PAGE','MESSAGES'); 
define('TITLE','Messages View');
include('includes/header.php');
include('../dbConnection.php');


if(!isset($_SESSION['is_adminlogin'])){
    echo "<script>location.href='../index.php'</script>";
}

// Handle status update via AJAX
if(isset($_POST['update_status'])) {
    $msg_id = mysqli_real_escape_string($conn, $_POST['msg_id']);
    $new_status = mysqli_real_escape_string($conn, $_POST['new_status']);
    $sql = "UPDATE contact_messages SET status='$new_status' WHERE id='$msg_id'";
    if($conn->query($sql)) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false]);
    }
    exit();
}

// Handle delete via AJAX
if(isset($_POST['delete_message'])) {
    $msg_id = mysqli_real_escape_string($conn, $_POST['msg_id']);
    $sql = "DELETE FROM contact_messages WHERE id='$msg_id'";
    if($conn->query($sql)) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false]);
    }
    exit();
}
?>

<div class="col-sm-9 col-md-10 maincontentheight px-2 py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3">Contact Messages</h1>
        <a href="messagesadd.php" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add New Message
        </a>
    </div>

    <?php if(isset($_SESSION['delete_msg'])): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success!</strong> <?php echo $_SESSION['delete_msg']; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION['delete_msg']); ?>
    <?php endif; ?>

    <div class="table-responsive">
        <table class="table table-bordered table-hover" id="messagesTable">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Message</th>
                    <th>Created At</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM contact_messages ORDER BY 
                        CASE status 
                            WHEN 'unread' THEN 1 
                            WHEN 'read' THEN 2 
                            WHEN 'replied' THEN 3 
                        END, created_at DESC";
                $result = $conn->query($sql);
                if($result->num_rows > 0) {
                    $count = 1;
                    while($row = $result->fetch_assoc()) {
                        $statusClass = '';
                        $statusText = '';
                        if($row['status'] == 'unread') {
                            $statusClass = 'danger';
                            $statusText = 'Unread';
                        }
                        if($row['status'] == 'read') {
                            $statusClass = 'warning';
                            $statusText = 'Read';
                        }
                        if($row['status'] == 'replied') {
                            $statusClass = 'success';
                            $statusText = 'Replied';
                        }
                        ?>
                        <tr id="row_<?php echo $row['id']; ?>">
                            <td><?php echo $count++; ?></td>
                            <td><strong><?php echo htmlspecialchars($row['name']); ?></strong></td>
                            <td><?php echo htmlspecialchars($row['email']); ?></td>
                            <td><?php echo substr(htmlspecialchars($row['message']), 0, 50) . '...'; ?></td>
                            <td><?php echo date('d-m-Y H:i', strtotime($row['created_at'])); ?></td>
                            <td>
                                <select class="form-select form-select-sm status-select" data-id="<?php echo $row['id']; ?>" style="width: 110px;">
                                    <option value="unread" <?php echo ($row['status'] == 'unread') ? 'selected' : ''; ?>>Unread</option>
                                    <option value="read" <?php echo ($row['status'] == 'read') ? 'selected' : ''; ?>>Read</option>
                                    <option value="replied" <?php echo ($row['status'] == 'replied') ? 'selected' : ''; ?>>Replied</option>
                                </select>
                                <span class="badge bg-<?php echo $statusClass; ?> status-badge-<?php echo $row['id']; ?>" style="display: none;">
                                    <?php echo $statusText; ?>
                                </span>
                             </td>
                            <td>
                                <a href="messagesview.php?id=<?php echo $row['id']; ?>" class="btn btn-info btn-sm" title="View">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="messagesupdate.php?id=<?php echo $row['id']; ?>" class="btn btn-primary btn-sm" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button onclick="deleteMessage(<?php echo $row['id']; ?>)" class="btn btn-danger btn-sm" title="Delete">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        <?php
                    }
                } else {
                    ?>
                    <tr>
                        <td colspan="7" class="text-center">
                            <div class="alert alert-info mb-0">
                                <i class="fas fa-inbox"></i> No Messages Found
                            </div>
                        </td>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $('.status-select').change(function() {
        var msg_id = $(this).data('id');
        var new_status = $(this).val();
        var $select = $(this);
        
        $.ajax({
            url: 'messages.php',
            method: 'POST',
            data: {
                update_status: true,
                msg_id: msg_id,
                new_status: new_status
            },
            success: function(response) {
                var result = JSON.parse(response);
                if(result.success) {
                    // Show success notification
                    var statusText = '';
                    var statusClass = '';
                    if(new_status == 'unread') {
                        statusText = 'Unread';
                        statusClass = 'danger';
                    }
                    if(new_status == 'read') {
                        statusText = 'Read';
                        statusClass = 'warning';
                    }
                    if(new_status == 'replied') {
                        statusText = 'Replied';
                        statusClass = 'success';
                    }
                    
                    // Update status badge
                    $('.status-badge-' + msg_id).removeClass('bg-danger bg-warning bg-success').addClass('bg-' + statusClass).text(statusText);
                    
                    // Show temporary notification
                    var notification = $('<div class="alert alert-success alert-dismissible fade show position-fixed top-0 end-0 m-3" style="z-index: 9999;" role="alert">Status updated to ' + statusText + '<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>');
                    $('body').append(notification);
                    setTimeout(function() {
                        notification.fadeOut('slow', function() {
                            $(this).remove();
                        });
                    }, 2000);
                }
            }
        });
    });
});

function deleteMessage(id) {
    if(confirm('Are you sure you want to delete this message? This action cannot be undone!')) {
        $.ajax({
            url: 'messages.php',
            method: 'POST',
            data: {
                delete_message: true,
                msg_id: id
            },
            success: function(response) {
                var result = JSON.parse(response);
                if(result.success) {
                    $('#row_' + id).fadeOut('slow', function() {
                        $(this).remove();
                        // Reload page if no messages left
                        if($('#messagesTable tbody tr').length == 0) {
                            location.reload();
                        }
                    });
                    
                    // Show success notification
                    var notification = $('<div class="alert alert-success alert-dismissible fade show position-fixed top-0 end-0 m-3" style="z-index: 9999;" role="alert">Message deleted successfully!<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>');
                    $('body').append(notification);
                    setTimeout(function() {
                        notification.fadeOut('slow', function() {
                            $(this).remove();
                        });
                    }, 2000);
                } else {
                    alert('Failed to delete message!');
                }
            }
        });
    }
}
</script>

<style>
.status-select {
    font-size: 12px;
    padding: 3px;
    display: inline-block;
    width: auto;
}
.btn-sm {
    margin: 0 2px;
}
#messagesTable tbody tr:hover {
    background-color: rgba(46, 163, 242, 0.1);
    cursor: pointer;
}
.position-fixed {
    position: fixed;
}
.top-0 {
    top: 0;
}
.end-0 {
    right: 0;
}
.m-3 {
    margin: 1rem;
}
</style>

<?php include('includes/footer.php'); ?>