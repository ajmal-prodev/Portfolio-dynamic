<?php 
	define('PAGE','PASSWORD'); 
	define('TITLE','Change Password');
    include('../dbConnection.php');
	include('includes/header.php');
	
	
	
	
	$aEmail = $_SESSION['aEmail'];
	if(isset($_REQUEST['passupdate']))
	{
		if($_REQUEST['aPassword']=="")
		{
			$passmsg = '<div class="alert alert-warning col-sm-6 ml-5 mt-2" role="alert">Fill All Fields.</div>';
		}
		else
		{
			$aPass = $_REQUEST['aPassword'];
			$sql = "UPDATE adminlogin_tb SET a_password ='$aPass' WHERE a_email ='$aEmail' ";
			if($conn->query($sql)==TRUE)
			{
				$passmsg = '<div class="alert alert-success col-sm-6 ml-5 mt-2" role="alert">Password Successfully Updated.</div>';
			}
			else
			{
				$passmsg = '<div class="alert alert-danger col-sm-6 ml-5 mt-2" role="alert">Unable to Update Your Password.</div>';
			}
		}
		
	}
	
?>

		<!--Start Profile Area 2nd Column-->
			<div class="col-sm-9 col-md-10 px-2 py-5 maincontentheight"><!--Start User Change Password Form 2nd Column-->
				<form class="mt-5 mx-5" action="" method="POST">
					<div class="form-group">
						<label for="inputEmail">Email</label>
						<input type="email" class="form-control" id="inputEmail" readonly value="<?php echo $aEmail; ?>">
					</div>
					<div class="form-group">
						<label for="inputnewpassword">New Password</label>
						<input type="password" class="form-control" id="inputnewpassword" placeholder="New Password" name="aPassword">
					</div>
					<button type="submit" class="btn btn-primary mr-4 mt-4" name="passupdate">Update</button>
					<button type="reset" class="btn btn-secondary mt-4">Reset</button>
					<?php if(isset($passmsg)){ echo $passmsg; }?>
				</form>
			</div><!--End User Change Password Form 2nd Column-->

		<!--End Profile Area 2nd Column-->




<?php
	include('includes/footer.php');
?>