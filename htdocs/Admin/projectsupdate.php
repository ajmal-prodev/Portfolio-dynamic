<?php 
	define('PAGE','PROJECTS'); 
	define('TITLE','PROJECTSUPDATE');
	include('includes/header.php');
    include('../dbConnection.php');
    
    $id = (int)$_GET['id'];
    $proj = $conn->query("SELECT * FROM projects WHERE id=$id")->fetch_assoc();
    
    if (!$proj) {
        echo "<script>alert('Project not found!'); location.href='projectsview.php';</script>";
        exit();
    }
    
    if (isset($_POST['update'])) {
        $title = mysqli_real_escape_string($conn, $_POST['title']);
        $desc = mysqli_real_escape_string($conn, $_POST['description']);
        $link = mysqli_real_escape_string($conn, $_POST['link']);
        $image = $proj['image'];
        
        $uploadDir = '../uploads/';
        
        if (!empty($_FILES['image']['name'])) {
            // Delete old image if it exists
            if(!empty($proj['image']) && file_exists($uploadDir . $proj['image'])) {
                unlink($uploadDir . $proj['image']);
            }
            $image = "project_" . time() . "_" . $_FILES['image']['name'];
            move_uploaded_file($_FILES['image']['tmp_name'], $uploadDir . $image);
        }
    
        $sql = "UPDATE projects SET title='$title', description='$desc', link='$link', image='$image' WHERE id=$id";
        
        if($conn->query($sql)) {
            echo "<script>alert('Project updated successfully!'); location.href='projectsview.php';</script>";
            exit();
        } else {
            echo "<script>alert('Error updating project: " . $conn->error . "');</script>";
        }
    }
?>

<div class="col-sm-9 col-md-10 maincontentheight px-2 py-5">
	<h1 class="text-center mb-4">Edit Project</h1>
	
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-lg-8">
				<div class="card shadow-sm border-0 rounded-4">
					<div class="card-body p-4">
						<form method="POST" enctype="multipart/form-data">
							<div class="mb-3">
								<label class="form-label fw-semibold">Project Title *</label>
								<input type="text" name="title" class="form-control" value="<?php echo htmlspecialchars($proj['title']); ?>" required>
							</div>
							
							<div class="mb-3">
								<label class="form-label fw-semibold">Description *</label>
								<textarea name="description" class="form-control" rows="3" required><?php echo htmlspecialchars($proj['description']); ?></textarea>
							</div>
							
							<div class="mb-3">
								<label class="form-label fw-semibold">Project Link *</label>
								<input type="url" name="link" class="form-control" value="<?php echo htmlspecialchars($proj['link']); ?>" required>
							</div>
							
							<div class="mb-3">
								<label class="form-label fw-semibold">Current Thumbnail</label>
								<?php 
								$imgPath = "../uploads/" . $proj['image'];
								if (!empty($proj['image']) && file_exists($imgPath)): 
								?>
									<div class="mb-2">
										<img src="<?php echo $imgPath; ?>?v=<?php echo time(); ?>" class="rounded-3" style="width: 200px; height: 120px; object-fit: cover;">
									</div>
								<?php else: ?>
									<p class="text-muted">No image found</p>
								<?php endif; ?>
								<input type="file" name="image" class="form-control" accept="image/*">
								<small class="text-muted">Leave empty to keep current image</small>
							</div>
							
							<div class="d-flex gap-3">
								<button type="submit" name="update" class="btn btn-primary px-4 py-2 rounded-pill">
									<i class="fas fa-save me-2"></i>Update Project
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