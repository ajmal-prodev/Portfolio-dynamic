<?php 
	define('PAGE','RESUME'); 
	define('TITLE','RESUME ADD');
	include('includes/header.php');
    include('../dbConnection.php');
    
    if (isset($_POST['submit'])) {
        $type = $_POST['type']; // 'exp' or 'edu'
        $desig_degree = mysqli_real_escape_string($conn, $_POST['title']);
        $org = mysqli_real_escape_string($conn, $_POST['organization']);
        $s_date = $_POST['start_date'];
        $e_date = $_POST['end_date'];
        $desc = mysqli_real_escape_string($conn, $_POST['description']);
    
        if ($type == 'exp') {
            $query = "INSERT INTO resume_experience (designation, company, start_date, end_date, description) VALUES ('$desig_degree', '$org', '$s_date', '$e_date', '$desc')";
        } else {
            $query = "INSERT INTO resume_education (degree, institution, start_date, end_date, description) VALUES ('$desig_degree', '$org', '$s_date', '$e_date', '$desc')";
        }
    
        if ($conn->query($query)) {
            echo "<script>alert('Resume entry added successfully!'); location.href='resumeview.php';</script>";
            exit();
        } else {
            echo "<script>alert('Error adding entry: " . $conn->error . "');</script>";
        }
    }
?>

<div class="col-sm-9 col-md-10 maincontentheight px-2 py-5">
	<h1 class="text-center mb-4">Add Resume Entry</h1>
	
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-lg-7">
				<div class="card shadow-sm border-0 rounded-4">
					<div class="card-body p-4">
						<form method="POST">
							<div class="mb-3">
								<label class="form-label fw-semibold">Entry Type *</label>
								<select name="type" class="form-select" required>
									<option value="exp">Work Experience</option>
									<option value="edu">Education / Certificate</option>
								</select>
							</div>
							
							<div class="mb-3">
								<label class="form-label fw-semibold">Title (Designation / Degree) *</label>
								<input type="text" name="title" class="form-control" placeholder="e.g., Senior Developer / B.Sc Computer Science" required>
							</div>
							
							<div class="mb-3">
								<label class="form-label fw-semibold">Organization (Company / Institution) *</label>
								<input type="text" name="organization" class="form-control" placeholder="e.g., Google / MIT" required>
							</div>
							
							<div class="row mb-3">
								<div class="col-md-6">
									<label class="form-label fw-semibold">Start Date *</label>
									<input type="date" name="start_date" class="form-control" required>
								</div>
								<div class="col-md-6">
									<label class="form-label fw-semibold">End Date</label>
									<input type="date" name="end_date" class="form-control">
									<small class="text-muted">Leave empty if currently working/studying</small>
								</div>
							</div>
							
							<div class="mb-4">
								<label class="form-label fw-semibold">Description</label>
								<textarea name="description" class="form-control" rows="4" placeholder="Key responsibilities, achievements, or subjects..."></textarea>
							</div>
							
							<div class="d-flex gap-3">
								<button type="submit" name="submit" class="btn btn-primary px-4 py-2 rounded-pill">
									<i class="fas fa-save me-2"></i>Save Entry
								</button>
								<a href="resumeview.php" class="btn btn-secondary px-4 py-2 rounded-pill">
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