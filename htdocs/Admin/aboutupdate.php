<?php 
	define('PAGE','ABOUT'); 
	define('TITLE','ABOUTUPDATE');
	include('includes/header.php');
    include('../dbConnection.php');
    
    $id = (int)$_GET['id'];
    $profile = $conn->query("SELECT * FROM about WHERE id=$id")->fetch_assoc();
    $skills = $conn->query("SELECT skill_name FROM about_skills WHERE profile_id=$id");
    
    if (!$profile) {
        echo "<script>alert('Profile not found!'); location.href='aboutview.php';</script>";
        exit();
    }
    
    if (isset($_POST['update'])) {
        $desc = mysqli_real_escape_string($conn, $_POST['description']);
        $image = $profile['image']; // Keep existing by default
        
        $uploadDir = '../uploads/';

        if (!empty($_FILES['image']['name'])) {
            // Delete old image if it exists
            if(!empty($profile['image']) && file_exists($uploadDir . $profile['image'])) {
                unlink($uploadDir . $profile['image']);
            }
            $image = time()."_".preg_replace("/[^a-zA-Z0-9.]/", "_", $_FILES['image']['name']);
            move_uploaded_file($_FILES['image']['tmp_name'], $uploadDir . $image);
        }
    
        $conn->query("UPDATE about SET description='$desc', image='$image' WHERE id=$id");
        
        // Skills sync
        $conn->query("DELETE FROM about_skills WHERE profile_id=$id");
        if(!empty($_POST['skills'])) {
            foreach ($_POST['skills'] as $skill) {
                if (!empty(trim($skill))) {
                    $skill = mysqli_real_escape_string($conn, $skill);
                    $conn->query("INSERT INTO about_skills (profile_id, skill_name) VALUES ($id, '$skill')");
                }
            }
        }
        echo "<script>alert('Profile updated successfully!'); location.href='aboutview.php';</script>";
        exit();
    }
?>

<div class="col-sm-9 col-md-10 maincontentheight px-2 py-5">
	<h1 class="text-center mb-4">Edit About Profile</h1>
	
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-lg-8">
				<div class="card shadow-sm border-0 rounded-4">
					<div class="card-body p-4">
						<form method="POST" enctype="multipart/form-data">
							<div class="mb-3">
								<label class="form-label fw-semibold">About Description</label>
								<textarea name="description" class="form-control" rows="6" required><?php echo htmlspecialchars($profile['description']); ?></textarea>
							</div>
							
							<div class="mb-3">
								<label class="form-label fw-semibold">Current Profile Picture</label>
								<?php 
								$imgPath = "../uploads/" . $profile['image'];
								if (!empty($profile['image']) && file_exists($imgPath)): 
								?>
									<div class="mb-2">
										<img src="<?php echo $imgPath; ?>?v=<?php echo time(); ?>" class="rounded-3" style="width: 120px; height: 120px; object-fit: cover;">
									</div>
								<?php else: ?>
									<p class="text-muted">No image found</p>
								<?php endif; ?>
								<input type="file" name="image" class="form-control" accept="image/*">
								<small class="text-muted">Leave empty to keep current image</small>
							</div>
							
							<div class="mb-3">
								<label class="form-label fw-semibold">Skills</label>
								<div id="skills-list">
									<?php 
									$skills->data_seek(0);
									if($skills->num_rows > 0):
										while($s = $skills->fetch_assoc()): 
									?>
										<div class="input-group mb-2">
											<input type="text" name="skills[]" class="form-control" value="<?php echo htmlspecialchars($s['skill_name']); ?>">
											<button type="button" class="btn btn-danger" onclick="this.parentElement.remove()">✕</button>
										</div>
									<?php 
										endwhile;
									else:
									?>
										<div class="input-group mb-2">
											<input type="text" name="skills[]" class="form-control" placeholder="Enter skill">
											<button type="button" class="btn btn-danger" onclick="this.parentElement.remove()">✕</button>
										</div>
									<?php endif; ?>
								</div>
								<button type="button" onclick="addSkill()" class="btn btn-primary btn-sm mt-2">+ Add Skill</button>
							</div>
							
							<div class="d-flex gap-3 mt-4">
								<button type="submit" name="update" class="btn btn-primary px-4 py-2 rounded-pill">Update Profile</button>
								<a href="aboutview.php" class="btn btn-secondary px-4 py-2 rounded-pill">Cancel</a>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
	function addSkill() {
		const div = document.createElement('div');
		div.className = 'input-group mb-2';
		div.innerHTML = `
			<input type="text" name="skills[]" class="form-control" placeholder="Skill">
			<button type="button" class="btn btn-danger" onclick="this.parentElement.remove()">✕</button>
		`;
		document.getElementById('skills-list').appendChild(div);
	}
</script>

<?php
	include('includes/footer.php');
?>