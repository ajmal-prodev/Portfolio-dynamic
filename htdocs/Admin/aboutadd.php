<?php 
	define('PAGE','ABOUT'); 
	define('TITLE','ABOUTADD');
	include('includes/header.php');
    include('../dbConnection.php');
    
    if (isset($_POST['submit'])) {
        $desc = mysqli_real_escape_string($conn, $_POST['description']);
        $imageName = "";

        // Create uploads directory if it doesn't exist
        $uploadDir = '../uploads/';
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
            // Unique name to prevent overwriting
            $imageName = time() . "_" . preg_replace("/[^a-zA-Z0-9.]/", "_", $_FILES['image']['name']);
            move_uploaded_file($_FILES['image']['tmp_name'], $uploadDir . $imageName);
        }

        $stmt = $conn->prepare("INSERT INTO about (description, image) VALUES (?, ?)");
        $stmt->bind_param("ss", $desc, $imageName);
        $stmt->execute();
        $profile_id = $conn->insert_id;

        if (!empty($_POST['skills'])) {
            $skillStmt = $conn->prepare("INSERT INTO about_skills (profile_id, skill_name) VALUES (?, ?)");
            foreach ($_POST['skills'] as $skill) {
                if (!empty(trim($skill))) {
                    $skillStmt->bind_param("is", $profile_id, $skill);
                    $skillStmt->execute();
                }
            }
        }
        echo "<script>alert('Profile created successfully!'); location.href='aboutview.php';</script>";
        exit();
    }
?>

<div class="col-sm-9 col-md-10 maincontentheight px-2 py-5">
	<h1 class="text-center mb-4">Create New About Profile</h1>
	
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-lg-8">
				<div class="card shadow-sm border-0 rounded-4">
					<div class="card-body p-4">
						<form method="POST" enctype="multipart/form-data">
							<div class="mb-3">
								<label class="form-label fw-semibold">About Description *</label>
								<textarea name="description" class="form-control" rows="6" placeholder="Write a detailed description about the person..." required></textarea>
							</div>
							
							<div class="mb-3">
								<label class="form-label fw-semibold">Profile Image *</label>
								<input type="file" name="image" class="form-control" accept="image/*" required>
								<small class="text-muted">Upload JPG, PNG or GIF (Max 5MB)</small>
							</div>
							
							<div class="mb-3">
								<label class="form-label fw-semibold">Skills</label>
								<div id="skills-area">
									<div class="input-group mb-2">
										<input type="text" name="skills[]" class="form-control" placeholder="Enter skill" required>
										<button type="button" class="btn btn-primary" onclick="addSkill()">+</button>
									</div>
								</div>
								<small class="text-muted">Add multiple skills (e.g., PHP, JavaScript, Design)</small>
							</div>
							
							<div class="d-flex gap-3 mt-4">
								<button type="submit" name="submit" class="btn btn-success px-4 py-2 rounded-pill">Create Profile</button>
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
		document.getElementById('skills-area').appendChild(div);
	}
</script>

<?php
	include('includes/footer.php');
?>