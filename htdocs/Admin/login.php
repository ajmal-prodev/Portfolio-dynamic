<?php
session_start();
require "../dbConnection.php";

$msg = "";

// If already logged in
if (isset($_SESSION["is_adminlogin"])) {
    header("Location: dashboard.php");
    exit;
}

// Default admin email (readonly)
$fixedEmail = "mohamedajmal.dev@gmail.com";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $password = trim($_POST["aPassword"]);

    // Fetch admin record
    $sql = "SELECT * FROM adminlogin_tb WHERE a_email='$fixedEmail' LIMIT 1";
    $res = $conn->query($sql);

    if ($res->num_rows == 1) {

        $admin = $res->fetch_assoc();

        // Direct plain password check (your DB uses plain text)
        if ($password === $admin["a_password"]) {

            // Generate OTP
            $otp = rand(100000, 999999);
            $expiry = date("Y-m-d H:i:s", strtotime("+10 minutes"));

            // Save OTP
            $conn->query("
                UPDATE adminlogin_tb 
                SET a_otp='$otp', a_otp_expiry='$expiry'
                WHERE a_login_id='{$admin['a_login_id']}'
            ");

            // Send OTP
            require "../mailer.php";
            sendOTP($fixedEmail, $otp);

            // Store temp session
            $_SESSION["verify_admin_id"] = $admin["a_login_id"];

            header("Location: verifylogin.php");
            exit;

        } else {
            $msg = '<div class="alert alert-danger mt-2">Incorrect Password!</div>';
        }
    } else {
        $msg = '<div class="alert alert-danger mt-2">Admin account not found!</div>';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../ASSETS/IMAGES/logotitle.jpg">
    <title>Admin Login</title>
    <link rel="stylesheet" href="../ASSETS/CDN/bootstrap.min.css">
</head>

<body>

<div class="container mt-5">
    <h2 class="text-center">Admin Login</h2>

    <div class="row justify-content-center">
        <div class="col-md-4">

            <form method="POST" class="shadow-lg p-4">

                <div class="form-group">
                    <label>Email</label>
                    <input type="email" class="form-control" value="mohamedajmal.dev@gmail.com" readonly>
                </div>

                <div class="form-group mt-3">
                    <label>Password</label>
                    <input type="password" class="form-control" name="aPassword" required>
                </div>

                <button class="btn btn-primary w-100 mt-4">Login</button>

                <?= $msg ?>

            </form>

        </div>
    </div>
</div>

</body>
</html>