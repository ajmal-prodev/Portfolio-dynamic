<?php
	include('../dbConnection.php');
	session_start();
	if($_SESSION['is_adminlogin'])
	{
		$rEmail = $_SESSION['aEmail'];
	}
	else
	{
		echo"<script>location.href='../index.php'</script>";
	}
	$aEmail = $_SESSION['aEmail'];
	$sql="SELECT a_theme FROM adminlogin_tb WHERE a_email='$aEmail'";
	$result = $conn->query($sql);
	if($result->num_rows ==1)
	{
		$row = $result->fetch_assoc();
		$atheme = $row['a_theme'];
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="widht=device-width,initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="id=edge">
    <link rel="shortcut icon" href="../ASSETS/IMAGES/logotitle.jpg">
	<title><?php echo TITLE;  ?></title>
	<!--bootstrap css-->
	<link rel="stylesheet" href="../ASSETS/CDN/bootstrap.min.css">
	<link rel="stylesheet" href="../ASSETS/CDN/bootstrap-icons-1.13.1/bootstrap-icons.css">
	<!--fontawesome css-->
	<link rel="stylesheet" href="../ASSETS/CDN/all.min.css">
	<style>
		.light .nav-link{
			color:black;
		}
		.light .active{
			color:#2ea3f2;
			background-color:#e8f4fd;
			border-radius:8px;
			
		}
		.light .nav-link:hover{
			color:#2ea3f2;
			background-color:#e8f4fd;
			border-radius:8px;
			
		}
		.light nav{
			background-color:#2ea3f2;
		}
		.light .navsidebg{
			background-color:white;
		}
		.light .maincontentheight{
			height:100vh;
			background-color:#f4f6f8;
		}
		.light .border-rounded{
			border-radius:8px;
		}
		.light .container-fluid{
			margin-top:40px;
		}
		
		
		.dark .nav-link{
			color:#94a3b8;
		}
		.dark .active{
			color:#2ea3f2;
			background-color:#e8f4fd;
			border-radius:8px;
			
		}
		.dark .nav-link:hover{
			color:#2ea3f2;
			background-color:#e8f4fd;
			border-radius:8px;
			
		}
		.dark nav{
			background-color:#2ea3f2;
		}
		.dark .navsidebg{
			background-color:#1e293b;
		}
		.dark .maincontentheight{
			min-height:100vh;
			background-color:#0f172a;
		}
		.dark .border-rounded{
			border-radius:8px;
		}
		.dark .container-fluid{
			margin-top:40px;
			color:white;
		}
		.dark input{
			background-color:#020617;
			color:#fff;
		}
		.dark select{
			background-color:#020617;
			color:#fff;
		}
		#viewbtn{
			background-color:#0d6efd;
		}
		#clsbtn{
			background-color:#6c757d;
		}
		#searchbtnwpr{
			background-color:#6c757d;
		}
		
	
		
	</style>
</head>
<body class="<?php echo $atheme; ?>">
	<!-- Top Navbar -->
	<nav class=" d-print-none navbar navbar-dark fixed-top flex-md-nowrap p-0 shadow">
		<a class="navbar-brand col-md-2 mr-0" href="dashboard.php">AJMAL</a>
	</nav>
	
	<!--Start Container-->
	<div class="container-fluid">
		<div class="row"><!--Start Row-->
			<nav class="col-sm-2 navsidebg sidebar  d-print-none"><!--Start Side Bar 1st column-->
				<div class="sidebar-sticky">
					<ul class="nav flex-column">
						<li class="nav-item border-rounded mt-2">
							<a class="nav-link <?php if(PAGE == "DASHBOARD"){echo 'active';} ?>" href="dashboard.php"><i class="bi bi-speedometer2"></i> Dashboard</a>
						</li>
						<li class="nav-item border-rounded mt-2">
							<a class="nav-link <?php if(PAGE == "HOME"){echo 'active';} ?>" href="homeview.php"><i class="bi bi-house"></i> HOME</a>
						</li>
						<li class="nav-item border-rounded mt-2">
							<a class="nav-link <?php if(PAGE =="ABOUT"){echo 'active';} ?>" href="aboutview.php"><i class="bi bi-person-circle"></i> ABOUT</a>
						</li>
						<li class="nav-item border-rounded mt-2">
							<a class="nav-link <?php if(PAGE =="SERVICES"){echo 'active';} ?>" href="servicesview.php"><i class="bi bi-gear"></i> SERVICES</a>
						</li>
						<li class="nav-item border-rounded mt-2">
							<a class="nav-link <?php if(PAGE =="PROJECTS"){echo 'active';} ?>" href="projectsview.php"><i class="bi bi-folder2-open"></i> PROJECTS</a>
						</li>
						<li class="nav-item border-rounded mt-2">
							<a class="nav-link <?php if(PAGE =="RESUME"){echo 'active';} ?>" href="resumeview.php"><i class="bi bi-file-earmark-person"></i> RESUME</a>
						</li>
						<li class="nav-item border-rounded mt-2">
							<a class="nav-link <?php if(PAGE =="CONTACT"){echo 'active';} ?>" href="contactview.php"><i class="bi bi-envelope-at"></i> CONTACT</a>
						</li>
						<li class="nav-item border-rounded mt-2">
							<a class="nav-link <?php if(PAGE =="MESSAGES"){echo 'active';} ?>" href="messages.php"><i class="bi bi-chat-dots"></i> MESSAGES</a>
						</li>
						<li class="nav-item border-rounded mt-2">
							<a class="nav-link <?php if(PAGE =="FOOTER"){echo 'active';} ?>" href="footerview.php"><i class="bi bi-layout-sidebar"></i> FOOTER</a>
						</li>
						<li class="nav-item border-rounded mt-2">
							<a class="nav-link <?php if(PAGE =="THEME"){echo 'active';} ?>" href="Changetheme.php"><i class="bi bi-palette"></i> CHANGE THEME</a>
						</li>
                        <li class="nav-item border-rounded mt-2">
							<a class="nav-link <?php if(PAGE =="PASSWORD"){echo 'active';} ?>" href="Changepassword.php"><i class="fas fa-key"></i> CHANGE PASSWORD</a>
						</li>
						<li class="nav-item border-rounded mt-2">
							<a class="nav-link" href="Logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
						</li>
					</ul>
				</div>
			</nav><!-- End Side Bar 1st Column-->
