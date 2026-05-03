<?php 
	define('PAGE','HOME'); 
	define('TITLE','HOMEADD');
	include('includes/header.php');
    include('../dbConnection.php');
    
    if (isset($_POST['submit'])) {
        // Handle multiple designations - store as JSON
        $designations = isset($_POST['designations']) ? $_POST['designations'] : [];
        $designation_json = json_encode(array_filter($designations));
        
        $name = $_POST['name'];
        $desc = $_POST['description'];
        $linkedin = $_POST['linkedin'];
        $github = $_POST['github'];
        $instagram = $_POST['instagram'];

        // Create uploads directory if it doesn't exist
        $uploadDir = '../uploads/';
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        // Enhanced File Upload Logic
        $imageName = time() . "_" . $_FILES['image']['name'];
        $resumeName = time() . "_" . $_FILES['resume']['name'];

        if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadDir . $imageName) && 
            move_uploaded_file($_FILES['resume']['tmp_name'], $uploadDir . $resumeName)) {
            
            $sql = "INSERT INTO home (designation, name, image, description, resume, linkedin, github, instagram) 
                    VALUES ('$designation_json', '$name', '$imageName', '$desc', '$resumeName', '$linkedin', '$github', '$instagram')";
            
            if ($conn->query($sql)) {
                echo "<script>alert('Record added successfully!'); location.href='homeview.php';</script>";
            } else {
                echo "<script>alert('Error: " . $conn->error . "');</script>";
            }
        } else {
            echo "<script>alert('Upload Failed. Check folder permissions or file size.');</script>";
        }
    }
?>

<div class="col-sm-9 col-md-10 maincontentheight px-2 py-5">
	<h1 class="text-center mb-4">Add New Portfolio Record</h1>
	
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-lg-8">
				<div class="card shadow-sm border-0 rounded-4">
					<div class="card-body p-4">
						<form method="POST" enctype="multipart/form-data">
							<div class="mb-3">
								<label class="form-label fw-semibold">Designations *</label>
								<div id="designations-container">
									<div class="input-group mb-2">
										<input type="text" name="designations[]" class="form-control" placeholder="e.g., Frontend Developer" required>
										<button type="button" class="btn btn-outline-primary" onclick="addDesignation()">
											<i class="fas fa-plus"></i>
										</button>
									</div>
								</div>
								<small class="text-muted">You can add multiple designations (e.g., Developer, Designer, Manager)</small>
							</div>
							
							<div class="mb-3">
								<label class="form-label fw-semibold">Full Name *</label>
								<input type="text" name="name" class="form-control" placeholder="e.g., John Doe" required>
							</div>
							
							<div class="mb-3">
								<label class="form-label fw-semibold">Profile Image *</label>
								<input type="file" name="image" class="form-control" accept="image/*" required>
								<small class="text-muted">Upload JPG, PNG or GIF (Max 5MB)</small>
							</div>
							
							<div class="mb-3">
								<label class="form-label fw-semibold">Description</label>
								<textarea name="description" class="form-control" rows="5" placeholder="Write a brief description about yourself..."></textarea>
							</div>
							
							<div class="mb-3">
								<label class="form-label fw-semibold">Resume (PDF) *</label>
								<input type="file" name="resume" class="form-control" accept=".pdf" required>
								<small class="text-muted">Upload PDF file only</small>
							</div>
							
							<div class="mb-3">
								<label class="form-label fw-semibold">LinkedIn Profile URL</label>
								<input type="url" name="linkedin" class="form-control" placeholder="https://linkedin.com/in/username">
							</div>
							
							<div class="mb-3">
								<label class="form-label fw-semibold">GitHub Profile URL</label>
								<input type="url" name="github" class="form-control" placeholder="https://github.com/username">
							</div>
							
							<div class="mb-4">
								<label class="form-label fw-semibold">Instagram Profile URL</label>
								<input type="url" name="instagram" class="form-control" placeholder="https://instagram.com/username">
							</div>
							
							<div class="d-flex gap-3">
								<button type="submit" name="submit" class="btn btn-success px-4 py-2 rounded-pill">Save Record</button>
								<a href="homeview.php" class="btn btn-secondary px-4 py-2 rounded-pill">Cancel</a>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
function addDesignation() {
    const container = document.getElementById('designations-container');
    const div = document.createElement('div');
    div.className = 'input-group mb-2';
    div.innerHTML = `
        <input type="text" name="designations[]" class="form-control" placeholder="e.g., UI/UX Designer" required>
        <button type="button" class="btn btn-outline-danger" onclick="this.parentElement.remove()">
            <i class="fas fa-times"></i>
        </button>
    `;
    container.appendChild(div);
}
</script>

<?php
	include('includes/footer.php');
?>