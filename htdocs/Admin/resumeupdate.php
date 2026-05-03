<?php 
	define('PAGE','RESUME'); 
	define('TITLE','RESUME UPDATE');
	include('includes/header.php');
    include('../dbConnection.php');
    
    $id = (int)$_GET['id'];
    $type = $_GET['type'];
    
    if ($type == 'exp') {
        $data = $conn->query("SELECT * FROM resume_experience WHERE id=$id")->fetch_assoc();
        if(!$data) {
            echo "<script>alert('Experience entry not found!'); location.href='resumeview.php';</script>";
            exit();
        }
        $title_val = $data['designation']; 
        $org_val = $data['company'];
    } else {
        $data = $conn->query("SELECT * FROM resume_education WHERE id=$id")->fetch_assoc();
        if(!$data) {
            echo "<script>alert('Education entry not found!'); location.href='resumeview.php';</script>";
            exit();
        }
        $title_val = $data['degree']; 
        $org_val = $data['institution'];
    }
    
    if (isset($_POST['update'])) {
        $t = mysqli_real_escape_string($conn, $_POST['title']);
        $o = mysqli_real_escape_string($conn, $_POST['org']);
        $s = $_POST['s_date'];
        $e = $_POST['e_date'];
        $d = mysqli_real_escape_string($conn, $_POST['desc']);
    
        if ($type == 'exp') {
            $conn->query("UPDATE resume_experience SET designation='$t', company='$o', start_date='$s', end_date='$e', description='$d' WHERE id=$id");
        } else {
            $conn->query("UPDATE resume_education SET degree='$t', institution='$o', start_date='$s', end_date='$e', description='$d' WHERE id=$id");
        }
        echo "<script>alert('Resume entry updated successfully!'); location.href='resumeview.php';</script>";
        exit();
    }
?>

<div class="col-sm-9 col-md-10 maincontentheight px-2 py-5">
	<h1 class="text-center mb-4">Edit Resume Entry</h1>
	
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-lg-7">
				<div class="card shadow-sm border-0 rounded-4">
					<div class="card-body p-4">
						<div class="mb-3">
							<span class="badge bg-primary mb-3 px-3 py-2 rounded-pill">
								<?php echo ($type == 'exp') ? 'Work Experience' : 'Education / Certificate'; ?>
							</span>
						</div>
						
						<form method="POST">
							<div class="mb-3">
								<label class="form-label fw-semibold">Title (Designation / Degree) *</label>
								<input type="text" name="title" class="form-control" value="<?php echo htmlspecialchars($title_val); ?>" required>
							</div>
							
							<div class="mb-3">
								<label class="form-label fw-semibold">Organization (Company / Institution) *</label>
								<input type="text" name="org" class="form-control" value="<?php echo htmlspecialchars($org_val); ?>" required>
							</div>
							
							<div class="row mb-3">
								<div class="col-md-6">
									<label class="form-label fw-semibold">Start Date *</label>
									<input type="date" name="s_date" class="form-control" value="<?php echo $data['start_date']; ?>" required>
								</div>
								<div class="col-md-6">
									<label class="form-label fw-semibold">End Date</label>
									<input type="date" name="e_date" class="form-control" value="<?php echo ($data['end_date'] != '0000-00-00') ? $data['end_date'] : ''; ?>">
									<small class="text-muted">Leave empty if currently ongoing</small>
								</div>
							</div>
							
							<div class="mb-4">
								<label class="form-label fw-semibold">Description</label>
								<textarea name="desc" class="form-control" rows="4"><?php echo htmlspecialchars($data['description']); ?></textarea>
							</div>
							
							<div class="d-flex gap-3">
								<button type="submit" name="update" class="btn btn-primary px-4 py-2 rounded-pill">
									<i class="fas fa-save me-2"></i>Update Entry
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