<?php


// Include database connection
include('dbConnection.php');

$contact_message = "";

if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['send_message'])) {
    // Get and sanitize form data
    $name = mysqli_real_escape_string($conn, trim($_POST['user_name']));
    $email = mysqli_real_escape_string($conn, trim($_POST['user_email']));
    $message = mysqli_real_escape_string($conn, trim($_POST['user_message']));
    $status = 'unread'; // Default status is unread
    
    // Validation
    $errors = [];
    if(empty($name)) $errors[] = "Name is required";
    if(empty($email)) $errors[] = "Email is required";
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Invalid email format";
    if(empty($message)) $errors[] = "Message is required";
    
    if(empty($errors)) {
        // Insert into database
        $sql = "INSERT INTO contact_messages (name, email, message, status, created_at) 
                VALUES ('$name', '$email', '$message', '$status', CURRENT_TIMESTAMP())";
        
        if($conn->query($sql)) {
            $contact_message = '<div class="success-message">Message sent successfully!</div>';
            // Clear form fields after successful submission
            $name = $email = $message = "";
        } else {
            $contact_message = '<div class="error-message">Error: Failed to send message. Please try again.</div>';
        }
    } else {
        $errorList = implode("<br>", $errors);
        $contact_message = '<div class="error-message">' . $errorList . '</div>';
    }
}
?>

<form action="" method="POST" class="contact__form grid" id="contact-form">
    <?php 
    if(!empty($contact_message)) {
        echo $contact_message;
    }
    ?>
    
    <input type="text" placeholder="Name" name="user_name" required class="contact__input" 
           value="<?php echo isset($name) ? htmlspecialchars($name) : ''; ?>">
    <input type="email" placeholder="Email" name="user_email" required class="contact__input"
           value="<?php echo isset($email) ? htmlspecialchars($email) : ''; ?>">
    
    <textarea placeholder="Message" name="user_message" required class="contact__input contact__area"><?php echo isset($message) ? htmlspecialchars($message) : ''; ?></textarea>
    
    <button type="submit" name="send_message" class="button">Send Message</button>
</form>

<style>
.success-message {
    background-color: #d4edda;
    color: #155724;
    padding: 10px;
    border-radius: 5px;
    margin-bottom: 15px;
    text-align: center;
}
.error-message {
    background-color: #f8d7da;
    color: #721c24;
    padding: 10px;
    border-radius: 5px;
    margin-bottom: 15px;
    text-align: center;
}
</style>