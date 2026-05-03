<?php 
	define('PAGE','HOME'); 
	define('TITLE','HOMEUPDATE');
	include('includes/header.php');
    include('../dbConnection.php');
    
    // Get the ID from URL
    $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
    
    // Fetch existing data
    $sql = "SELECT * FROM home WHERE id = $id";
    $result = $conn->query($sql);
    
    if ($result && $result->num_rows > 0) {
        $data = $result->fetch_assoc();
        // Decode JSON designations to array
        $designations = json_decode($data['designation'], true);
        if (!is_array($designations)) {
            $designations = !empty($data['designation']) ? [$data['designation']] : [''];
        }
    } else {
        echo "<script>alert('Record not found!'); location.href='homeview.php';</script>";
        exit();
    }
    
    if (isset($_POST['update'])) {
        // Handle multiple designations - store as JSON
        $designations = isset($_POST['designations']) ? $_POST['designations'] : [];
        $designation_json = json_encode(array_filter($designations));
        
        $name = $_POST['name'];
        $desc = $_POST['description'];
        $linkedin = $_POST['linkedin'];
        $github = $_POST['github'];
        $instagram = $_POST['instagram'];

        // Keep old file names by default
        $image = $data['image'];
        $resume = $data['resume'];

        // If new image uploaded
        if(!empty($_FILES['image']['name'])) {
            $uploadDir = '../uploads/';
            // Delete old image
            if(file_exists($uploadDir . $data['image'])) {
                unlink($uploadDir . $data['image']);
            }
            $image = time()."_".$_FILES['image']['name'];
            move_uploaded_file($_FILES['image']['tmp_name'], $uploadDir.$image);
        }
        // If new PDF uploaded
        if(!empty($_FILES['resume']['name'])) {
            $uploadDir = '../uploads/';
            // Delete old resume
            if(file_exists($uploadDir . $data['resume'])) {
                unlink($uploadDir . $data['resume']);
            }
            $resume = time()."_".$_FILES['resume']['name'];
            move_uploaded_file($_FILES['resume']['tmp_name'], $uploadDir.$resume);
        }

        $sql = "UPDATE home SET 
                designation='$designation_json', 
                name='$name', 
                description='$desc', 
                image='$image', 
                resume='$resume', 
                linkedin='$linkedin', 
                github='$github', 
                instagram='$instagram' 
                WHERE id=$id";
        
        if($conn->query($sql)) {
            echo "<script>alert('Record updated successfully!'); location.href='homeview.php';</script>";
        } else {
            echo "<script>alert('Error updating record: " . $conn->error . "');</script>";
        }
    }
?>

<div class="col-sm-9 col-md-10 maincontentheight px-2 py-5">
	<h1 class="text-center mb-4">Update Portfolio Record</h1>
	
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-lg-8">
				<div class="card shadow-sm border-0 rounded-4">
					<div class="card-body p-4">
						<form method="POST" enctype="multipart/form-data">
							<input type="hidden" name="id" value="<?php echo $data['id']; ?>">
							
							<div class="mb-3">
								<label class="form-label fw-semibold">Designations *</label>
								<div id="designations-container">
									<?php 
									if(!empty($designations)) {
										foreach($designations as $index => $desig):
											if(!empty($desig)):
									?>
									<div class="input-group mb-2">
										<input type="text" name="designations[]" class="form-control" value="<?php echo htmlspecialchars($desig); ?>" required>
										<button type="button" class="btn btn-outline-danger" onclick="this.parentElement.remove()">
											<i class="fas fa-times"></i>
										</button>
									</div>
									<?php 
											endif;
										endforeach;
									} else {
									?>
									<div class="input-group mb-2">
										<input type="text" name="designations[]" class="form-control" placeholder="e.g., Frontend Developer" required>
										<button type="button" class="btn btn-outline-primary" onclick="addDesignation()">
											<i class="fas fa-plus"></i>
										</button>
									</div>
									<?php } ?>
								</div>
								<small class="text-muted">You can add multiple designations</small>
							</div>
							
							<div class="mb-3">
								<label class="form-label fw-semibold">Full Name *</label>
								<input type="text" name="name" class="form-control" value="<?php echo htmlspecialchars($data['name']); ?>" required>
							</div>
							
							<div class="mb-3">
								<label class="form-label fw-semibold">Current Profile Image</label><br>
								<?php 
								$imgPath = "../uploads/" . $data['image'];
								if (file_exists($imgPath)) {
									echo "<img src='$imgPath' style='width:100px; height:100px; object-fit:cover; border-radius:10px; margin-bottom:10px;'>";
								} else {
									echo "<p class='text-muted'>No image found</p>";
								}
								?>
								<input type="file" name="image" class="form-control mt-2" accept="image/*">
								<small class="text-muted">Leave empty to keep current image</small>
							</div>
							
							<div class="mb-3">
								<label class="form-label fw-semibold">Description</label>
								<textarea name="description" class="form-control" rows="5"><?php echo htmlspecialchars($data['description']); ?></textarea>
							</div>
							
							<div class="mb-3">
								<label class="form-label fw-semibold">Current Resume</label><br>
								<?php 
								if (!empty($data['resume'])) {
									echo "<a href='../uploads/" . $data['resume'] . "' target='_blank' class='btn btn-sm btn-warning mb-2'>View Current Resume</a>";
								} else {
									echo "<p class='text-muted'>No resume uploaded</p>";
								}
								?>
								<input type="file" name="resume" class="form-control mt-2" accept=".pdf">
								<small class="text-muted">Leave empty to keep current resume</small>
							</div>
							
							<div class="mb-3">
								<label class="form-label fw-semibold">LinkedIn Profile URL</label>
								<input type="url" name="linkedin" class="form-control" value="<?php echo htmlspecialchars($data['linkedin']); ?>">
							</div>
							
							<div class="mb-3">
								<label class="form-label fw-semibold">GitHub Profile URL</label>
								<input type="url" name="github" class="form-control" value="<?php echo htmlspecialchars($data['github']); ?>">
							</div>
							
							<div class="mb-4">
								<label class="form-label fw-semibold">Instagram Profile URL</label>
								<input type="url" name="instagram" class="form-control" value="<?php echo htmlspecialchars($data['instagram']); ?>">
							</div>
							
							<div class="d-flex gap-3">
								<button type="submit" name="update" class="btn btn-primary px-4 py-2 rounded-pill">Update Record</button>
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