<?php 
	define('PAGE','PROJECTS'); 
	define('TITLE','PROJECTSADD');
	include('includes/header.php');
    include('../dbConnection.php');
    
    if (isset($_POST['submit'])) {
        $title = mysqli_real_escape_string($conn, $_POST['title']);
        $desc = mysqli_real_escape_string($conn, $_POST['description']);
        $link = mysqli_real_escape_string($conn, $_POST['link']);
        
        // Create uploads directory if it doesn't exist
        $uploadDir = '../uploads/';
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        
        $imageName = "";
        if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
            $imageName = "project_" . time() . "_" . $_FILES['image']['name'];
            move_uploaded_file($_FILES['image']['tmp_name'], $uploadDir . $imageName);
        }
    
        $stmt = $conn->prepare("INSERT INTO projects (title, description, link, image) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $title, $desc, $link, $imageName);
        
        if($stmt->execute()) {
            echo "<script>alert('Project added successfully!'); location.href='projectsview.php';</script>";
            exit();
        } else {
            echo "<script>alert('Error adding project: " . $conn->error . "');</script>";
        }
    }
?>

<div class="col-sm-9 col-md-10 maincontentheight px-2 py-5">
	<h1 class="text-center mb-4">Add New Project</h1>
	
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-lg-8">
				<div class="card shadow-sm border-0 rounded-4">
					<div class="card-body p-4">
						<form method="POST" enctype="multipart/form-data">
							<div class="mb-3">
								<label class="form-label fw-semibold">Project Title *</label>
								<input type="text" name="title" class="form-control" placeholder="Enter project name" required>
							</div>
							
							<div class="mb-3">
								<label class="form-label fw-semibold">Description *</label>
								<textarea name="description" class="form-control" rows="3" placeholder="Brief description of the project" required></textarea>
								<small class="text-muted">Keep it short and concise (2-3 lines)</small>
							</div>
							
							<div class="mb-3">
								<label class="form-label fw-semibold">Project Link *</label>
								<input type="url" name="link" class="form-control" placeholder="https://github.com/username/project" required>
								<small class="text-muted">GitHub, live demo, or any project URL</small>
							</div>
							
							<div class="mb-4">
								<label class="form-label fw-semibold">Project Thumbnail *</label>
								<input type="file" name="image" class="form-control" accept="image/*" required>
								<small class="text-muted">Upload JPG, PNG or GIF (Recommended size: 400x250px)</small>
							</div>
							
							<div class="d-flex gap-3">
								<button type="submit" name="submit" class="btn btn-primary px-4 py-2 rounded-pill">
									<i class="fas fa-save me-2"></i>Save Project
								</button>
								<a href="projectsview.php" class="btn btn-secondary px-4 py-2 rounded-pill">
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