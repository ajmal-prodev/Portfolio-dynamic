<?php 
	define('PAGE','FOOTER'); 
	define('TITLE','FOOTERADD');
	include('includes/header.php');
    include('../dbConnection.php');
    
    // Fetch current data to pre-fill the form
    $res = $conn->query("SELECT * FROM footer WHERE id=1");
    $data = $res->fetch_assoc();
    
    if (isset($_POST['submit'])) {
        $fb = mysqli_real_escape_string($conn, $_POST['facebook']);
        $ig = mysqli_real_escape_string($conn, $_POST['instagram']);
        $tw = mysqli_real_escape_string($conn, $_POST['twitter']);
        $yt = mysqli_real_escape_string($conn, $_POST['youtube']);
    
        $sql = "INSERT INTO footer (id, facebook, instagram, twitter_x, youtube) 
                VALUES (1, '$fb', '$ig', '$tw', '$yt')
                ON DUPLICATE KEY UPDATE 
                facebook='$fb', instagram='$ig', twitter_x='$tw', youtube='$yt'";
    
        if ($conn->query($sql)) {
            echo "<script>alert('Footer settings updated successfully!'); location.href='footerview.php';</script>";
            exit();
        } else {
            echo "<script>alert('Error updating footer: " . $conn->error . "');</script>";
        }
    }
?>

<div class="col-sm-9 col-md-10 maincontentheight px-2 py-5">
	<h1 class="text-center mb-4">Footer Settings</h1>
	
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-lg-8">
				<div class="card shadow-sm border-0 rounded-4">
					<div class="card-body p-4">
						<h4 class="mb-4">Manage Social Media Links</h4>
						
						<form method="POST">
							<div class="mb-3">
								<label class="form-label fw-semibold">
									<i class="fab fa-facebook text-primary me-2"></i>Facebook Link
								</label>
								<input type="text" name="facebook" class="form-control" value="<?php echo $data['facebook'] ?? ''; ?>" placeholder="https://facebook.com/yourpage">
								<small class="text-muted">Enter full URL including https://</small>
							</div>
							
							<div class="mb-3">
								<label class="form-label fw-semibold">
									<i class="fab fa-instagram text-danger me-2"></i>Instagram Link
								</label>
								<input type="text" name="instagram" class="form-control" value="<?php echo $data['instagram'] ?? ''; ?>" placeholder="https://instagram.com/username">
								<small class="text-muted">Enter full URL including https://</small>
							</div>
							
							<div class="mb-3">
								<label class="form-label fw-semibold">
									<i class="fab fa-twitter text-info me-2"></i>Twitter (X) Link
								</label>
								<input type="text" name="twitter" class="form-control" value="<?php echo $data['twitter_x'] ?? ''; ?>" placeholder="https://x.com/username">
								<small class="text-muted">Enter full URL including https://</small>
							</div>
							
							<div class="mb-4">
								<label class="form-label fw-semibold">
									<i class="fab fa-youtube text-danger me-2"></i>YouTube Link
								</label>
								<input type="text" name="youtube" class="form-control" value="<?php echo $data['youtube'] ?? ''; ?>" placeholder="https://youtube.com/c/channel">
								<small class="text-muted">Enter full URL including https://</small>
							</div>
							
							<div class="d-flex gap-3">
								<button type="submit" name="submit" class="btn btn-primary px-4 py-2 rounded-pill">Update Footer</button>
								<a href="footerview.php" class="btn btn-secondary px-4 py-2 rounded-pill">Cancel</a>
							</div>
						</form>
					</div>
				</div>
				
				<div class="card shadow-sm border-0 rounded-4 mt-4">
					<div class="card-body p-4">
						<h5 class="mb-3">Preview</h5>
						<div class="bg-dark text-white rounded-3 p-3 text-center" style="background: #111;">
							<div class="d-flex justify-content-center gap-3 mb-2">
								<?php if(!empty($data['facebook'])): ?>
									<i class="fab fa-facebook text-white-50"></i>
								<?php endif; ?>
								<?php if(!empty($data['instagram'])): ?>
									<i class="fab fa-instagram text-white-50"></i>
								<?php endif; ?>
								<?php if(!empty($data['twitter_x'])): ?>
									<i class="fab fa-twitter text-white-50"></i>
								<?php endif; ?>
								<?php if(!empty($data['youtube'])): ?>
									<i class="fab fa-youtube text-white-50"></i>
								<?php endif; ?>
							</div>
							<p class="text-secondary small mb-0">&copy; <?php echo date("Y"); ?> Portfolio</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php
	include('includes/footer.php');
?>