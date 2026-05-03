<?php
session_start();
require "../dbConnection.php";

if (!isset($_SESSION["verify_admin_id"])) {
    die("No login session. Please login again.");
}

$admin_id = $_SESSION["verify_admin_id"];

$res = $conn->query("SELECT * FROM adminlogin_tb WHERE a_login_id='$admin_id'");
$admin = $res->fetch_assoc();

if (!$admin) die("Admin not found!");

$msg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $otp = trim($_POST["otp"]);

    if ($otp == $admin['a_otp'] && strtotime($admin["a_otp_expiry"]) >= time()) {

        $_SESSION["is_adminlogin"] = true;
        $_SESSION["aEmail"] = $admin["a_email"];

        unset($_SESSION["verify_admin_id"]);

        header("Location: dashboard.php");
        exit;

    } else {
        $msg = '<div class="alert alert-danger mt-2">Invalid or expired OTP!</div>';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../ASSETS/IMAGES/logotitle.jpg">
    <title>Verify Admin OTP</title>
    <link rel="stylesheet" href="../ASSETS/CDN/bootstrap.min.css">
</head>

<body>

<div class="container mt-5">

    <h3 class="text-center">Verify Admin Login</h3>

    <div class="row justify-content-center mt-4">
        <div class="col-md-4">

            <form method="POST" class="shadow-lg p-4">

                <label>Enter OTP</label>
                <input type="text" name="otp" maxlength="6" class="form-control" required>

                <button class="btn btn-primary w-100 mt-4">Verify OTP</button>

                <?= $msg ?>

            </form>

        </div>
    </div>
</div>

</body>
</html>