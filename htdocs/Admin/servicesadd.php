<?php 
	define('PAGE','SERVICES'); 
	define('TITLE','SERVICESADD');
	include('includes/header.php');
    include('../dbConnection.php');
    
    if (isset($_POST['submit'])) {
        $icon = mysqli_real_escape_string($conn, $_POST['icon']);
        $desig = mysqli_real_escape_string($conn, $_POST['designation']);
        $desc = mysqli_real_escape_string($conn, $_POST['description']);
        $link = mysqli_real_escape_string($conn, $_POST['link']);
    
        $query = "INSERT INTO services (icon_class, designation, description, link) 
                  VALUES ('$icon', '$desig', '$desc', '$link')";
        
        if ($conn->query($query)) {
            echo "<script>alert('Service added successfully!'); location.href='servicesview.php';</script>";
            exit();
        } else {
            echo "<script>alert('Error adding service: " . $conn->error . "');</script>";
        }
    }
?>

<div class="col-sm-9 col-md-10 maincontentheight px-2 py-5">
	<h1 class="text-center mb-4">Add New Service</h1>
	
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-lg-7">
				<div class="card shadow-sm border-0 rounded-4">
					<div class="card-body p-4">
						<form method="POST">
							<div class="mb-3">
								<label class="form-label fw-semibold">Icon Class (Font Awesome) *</label>
								<input type="text" name="icon" class="form-control" placeholder="e.g., fas fa-laptop-code" required>
								<small class="text-muted">
									Find icons at <a href="https://fontawesome.com/v5/search?m=free" target="_blank">FontAwesome</a>
									<br>Example: fas fa-code, fas fa-paint-brush, fas fa-mobile-alt
								</small>
							</div>
							
							<div class="mb-3">
								<label class="form-label fw-semibold">Service Designation *</label>
								<input type="text" name="designation" class="form-control" placeholder="e.g., Web Development" required>
							</div>
							
							<div class="mb-3">
								<label class="form-label fw-semibold">Description *</label>
								<textarea name="description" class="form-control" rows="4" placeholder="Describe what you offer..." required></textarea>
							</div>
							
							<div class="mb-4">
								<label class="form-label fw-semibold">Service Link</label>
								<input type="url" name="link" class="form-control" placeholder="https://yourlink.com/service">
								<small class="text-muted">Optional: Link to service details or portfolio page</small>
							</div>
							
							<div class="d-flex gap-3">
								<button type="submit" name="submit" class="btn btn-primary px-4 py-2 rounded-pill">
									<i class="fas fa-save me-2"></i>Publish Service
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