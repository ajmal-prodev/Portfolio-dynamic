<?php 
	define('PAGE','SERVICES'); 
	define('TITLE','SERVICESUPDATE');
	include('includes/header.php');
    include('../dbConnection.php');
    
    // Check if ID exists in the URL
    if (!isset($_GET['id'])) {
        echo "<script>alert('No ID provided!'); location.href='servicesview.php';</script>";
        exit();
    }
    
    $id = (int)$_GET['id'];
    
    // Fetch the current data to pre-fill the form
    $result = $conn->query("SELECT * FROM services WHERE id=$id");
    
    if ($result->num_rows == 0) {
        echo "<script>alert('Service not found!'); location.href='servicesview.php';</script>";
        exit();
    }
    
    $row = $result->fetch_assoc();
    
    // Handle the Update Logic
    if (isset($_POST['update'])) {
        $icon = mysqli_real_escape_string($conn, $_POST['icon']);
        $desig = mysqli_real_escape_string($conn, $_POST['designation']);
        $desc = mysqli_real_escape_string($conn, $_POST['description']);
        $link = mysqli_real_escape_string($conn, $_POST['link']);
    
        $sql = "UPDATE services SET 
                icon_class='$icon', 
                designation='$desig', 
                description='$desc', 
                link='$link' 
                WHERE id=$id";
    
        if ($conn->query($sql)) {
            echo "<script>alert('Service updated successfully!'); location.href='servicesview.php';</script>";
            exit();
        } else {
            echo "<script>alert('Error updating service: " . $conn->error . "');</script>";
        }
    }
?>

<div class="col-sm-9 col-md-10 maincontentheight px-2 py-5">
	<h1 class="text-center mb-4">Edit Service</h1>
	
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-lg-7">
				<div class="card shadow-sm border-0 rounded-4">
					<div class="card-body p-4">
						<div class="mb-3 text-center">
							<div class="mx-auto mb-2 d-flex align-items-center justify-content-center" style="width: 60px; height: 60px; background: #eef2ff; border-radius: 50%;">
								<i class="<?php echo htmlspecialchars($row['icon_class']); ?> fa-2x" style="color: #4834d4;"></i>
							</div>
							<small class="text-muted">Current Icon Preview</small>
						</div>
						
						<form method="POST">
							<div class="mb-3">
								<label class="form-label fw-semibold">Icon Class (Font Awesome)</label>
								<input type="text" name="icon" class="form-control" value="<?php echo htmlspecialchars($row['icon_class']); ?>" required>
								<small class="text-muted">e.g., fas fa-laptop-code, fas fa-paint-brush</small>
							</div>
							
							<div class="mb-3">
								<label class="form-label fw-semibold">Service Designation</label>
								<input type="text" name="designation" class="form-control" value="<?php echo htmlspecialchars($row['designation']); ?>" required>
							</div>
							
							<div class="mb-3">
								<label class="form-label fw-semibold">Description</label>
								<textarea name="description" class="form-control" rows="4" required><?php echo htmlspecialchars($row['description']); ?></textarea>
							</div>
							
							<div class="mb-4">
								<label class="form-label fw-semibold">Service Link</label>
								<input type="url" name="link" class="form-control" value="<?php echo htmlspecialchars($row['link']); ?>" placeholder="https://yourlink.com/service">
							</div>
							
							<div class="d-flex gap-3">
								<button type="submit" name="update" class="btn btn-primary px-4 py-2 rounded-pill">
									<i class="fas fa-save me-2"></i>Update Service
								</button>
								<a href="servicesview.php" class="btn btn-secondary px-4 py-2 rounded-pill">
									<i class="fas fa-times me-2"></i>Cancel
								</a>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php
	include('includes/footer.php');
?>