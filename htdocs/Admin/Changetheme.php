<?php
	define('TITLE','Change Theme');
	define('PAGE','THEME');
	include('includes/header.php');
	include('../dbConnection.php');
	if(isset($_REQUEST['themeupdate']))
	{
		if($_REQUEST['mode']=="")
		{
			$passmsg = '<div class="alert alert-warning col-sm-6 ml-5 mt-2" role="alert">Fill All Fields.</div>';
		}
		else
		{
			$atheme = $_REQUEST['mode'];
			$sql = "UPDATE adminlogin_tb SET a_theme ='$atheme' WHERE a_email ='$aEmail' ";
			if($conn->query($sql)==TRUE)
			{
				$passmsg = '<div class="alert alert-success col-sm-6 ml-5 mt-2" role="alert">Theme Successfully Updated.</div>';
				echo'<meta http-equiv="refresh" content="0;URL=?themechanged" />';
				
			}
			else
			{
				$passmsg = '<div class="alert alert-danger col-sm-6 ml-5 mt-2" role="alert">Unable to Update Your Theme.</div>';
			}
		}
		
	}
	
?>








		

		<!--Start Profile Area 2nd Column-->
			<div class="col-sm-9 col-md-10 px-2 py-5 maincontentheight"><!--Start User Change Password Form 2nd Column-->
				<form class="mt-5" action="" method="POST">
					<div class="form-group">
						<label for="inputEmail">Dark Theme</label>
						<input type="radio" class="form-control" id="inputdarktheme" name="mode" value="dark">
					</div>
					<div class="form-group">
						<label for="inputnewpassword">Light Theme</label>
						<input type="radio" class="form-control" id="inputlighttheme" name="mode" value="light">
					</div>
					<button type="submit" class="btn btn-primary mr-4 mt-4" name="themeupdate">Update</button>
					<button type="reset" class="btn btn-secondary mt-4">Reset</button>
					<?php if(isset($passmsg)){ echo $passmsg; }?>
				</form>
			</div><!--End User Change Password Form 2nd Column-->

		<!--End Profile Area 2nd Column-->

<?php 
	include('includes/footer.php');
?>





