<?php 
	define('PAGE','RESUME'); 
	define('TITLE','RESUME');
	include('includes/header.php');
    include('../dbConnection.php');
?>

<div class="col-sm-9 col-md-10 maincontentheight px-2 py-5">
	<div class="container-fluid px-0">
		<div class="d-flex justify-content-between align-items-center mb-4">
			<h1 class="mb-0">Professional Resume</h1>
			<a href="resumeadd.php" class="btn btn-primary rounded-pill px-4">
				<i class="fas fa-plus me-2"></i>Add Entry
			</a>
		</div>
		
		<div class="row">
			<div class="col-lg-6 mb-4">
				<div class="card shadow-sm border-0 rounded-4 h-100">
					<div class="card-body p-4">
						<h4 class="mb-4 pb-2 border-bottom border-primary" style="color: #4834d4;">
							<i class="fas fa-briefcase me-2"></i>Work Experience
						</h4>
						
						<?php
						$exp = $conn->query("SELECT * FROM resume_experience ORDER BY start_date DESC");
						if($exp && $exp->num_rows > 0) {
							while($row = $exp->fetch_assoc()):
						?>
						<div class="position-relative ps-3 mb-4" style="border-left: 2px solid #4834d4;">
							<div class="position-absolute" style="left: -7px; top: 5px; width: 12px; height: 12px; background: #4834d4; border-radius: 50%;"></div>
							<h5 class="fw-bold mb-1"><?php echo htmlspecialchars($row['designation']); ?></h5>
							<p class="text-secondary mb-1"><?php echo htmlspecialchars($row['company']); ?></p>
							<p class="text-muted small mb-2">
								<i class="far fa-calendar-alt me-1"></i>
								<?php echo date("M Y", strtotime($row['start_date'])); ?> — 
								<?php echo ($row['end_date'] == '0000-00-00' || empty($row['end_date'])) ? 'Present' : date("M Y", strtotime($row['end_date'])); ?>
							</p>
							<p class="text-secondary small"><?php echo nl2br(htmlspecialchars($row['description'])); ?></p>
							<div class="mt-2">
								<a href="resumeupdate.php?type=exp&id=<?php echo $row['id']; ?>" class="btn btn-sm btn-outline-warning rounded-pill me-2">
									<i class="fas fa-edit me-1"></i>Edit
								</a>
								<a href="delete.php?type=exp&id=<?php echo $row['id']; ?>" class="btn btn-sm btn-outline-danger rounded-pill" onclick="return confirm('Delete this entry?')">
									<i class="fas fa-trash me-1"></i>Delete
								</a>
							</div>
						</div>
						<?php 
							endwhile;
						} else {
						?>
						<div class="text-center py-4">
							<i class="fas fa-briefcase fa-3x text-muted mb-3"></i>
							<p class="text-muted">No work experience added yet</p>
						</div>
						<?php } ?>
					</div>
				</div>
			</div>
			
			<div class="col-lg-6 mb-4">
				<div class="card shadow-sm border-0 rounded-4 h-100">
					<div class="card-body p-4">
						<h4 class="mb-4 pb-2 border-bottom border-primary" style="color: #4834d4;">
							<i class="fas fa-graduation-cap me-2"></i>Education & Certifications
						</h4>
						
						<?php
						$edu = $conn->query("SELECT * FROM resume_education ORDER BY start_date DESC");
						if($edu && $edu->num_rows > 0) {
							while($row = $edu->fetch_assoc()):
						?>
						<div class="position-relative ps-3 mb-4" style="border-left: 2px solid #4834d4;">
							<div class="position-absolute" style="left: -7px; top: 5px; width: 12px; height: 12px; background: #4834d4; border-radius: 50%;"></div>
							<h5 class="fw-bold mb-1"><?php echo htmlspecialchars($row['degree']); ?></h5>
							<p class="text-secondary mb-1"><?php echo htmlspecialchars($row['institution']); ?></p>
							<p class="text-muted small mb-2">
								<i class="far fa-calendar-alt me-1"></i>
								<?php echo date("M Y", strtotime($row['start_date'])); ?> — 
								<?php echo date("M Y", strtotime($row['end_date'])); ?>
							</p>
							<p class="text-secondary small"><?php echo nl2br(htmlspecialchars($row['description'])); ?></p>
							<div class="mt-2">
								<a href="resumeupdate.php?type=edu&id=<?php echo $row['id']; ?>" class="btn btn-sm btn-outline-warning rounded-pill me-2">
									<i class="fas fa-edit me-1"></i>Edit
								</a>
								<a href="resumedelete.php?type=edu&id=<?php echo $row['id']; ?>" class="btn btn-sm btn-outline-danger rounded-pill" onclick="return confirm('Delete this entry?')">
									<i class="fas fa-trash me-1"></i>Delete
								</a>
							</div>
						</div>
						<?php 
							endwhile;
						} else {
						?>
						<div class="text-center py-4">
							<i class="fas fa-graduation-cap fa-3x text-muted mb-3"></i>
							<p class="text-muted">No education added yet</p>
						</div>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php
	include('includes/footer.php');
?>