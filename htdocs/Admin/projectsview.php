<?php 
	define('PAGE','PROJECTS'); 
	define('TITLE','PROJECTS');
	include('includes/header.php');
    include('../dbConnection.php');
?>

<div class="col-sm-9 col-md-10 maincontentheight px-2 py-5">
	<h1 class="text-center mb-4">My Projects</h1>
	
	<div class="container-fluid px-0">
		<div class="d-flex justify-content-end mb-4">
			<a href="projectsadd.php" class="btn btn-primary rounded-pill px-4">
				<i class="fas fa-plus me-2"></i>New Project
			</a>
		</div>
		
		<div class="row">
			<?php
			$res = $conn->query("SELECT * FROM projects ORDER BY id DESC");
			if($res && $res->num_rows > 0) {
				while($row = $res->fetch_assoc()):
					$img = "../uploads/" . $row['image'];
			?>
			<div class="col-md-6 col-lg-4 mb-4">
				<div class="card shadow-sm border-0 rounded-4 h-100 overflow-hidden transition-all" style="transition: transform 0.3s;">
					<div class="position-relative overflow-hidden" style="height: 220px;">
						<img src="<?php echo (file_exists($img) && !empty($row['image'])) ? $img : 'https://via.placeholder.com/400x250?text=No+Image'; ?>?v=<?php echo time(); ?>" 
							 class="w-100 h-100 object-fit-cover" style="object-fit: cover;">
					</div>
					<div class="card-body p-4">
						<h5 class="card-title fw-bold mb-2"><?php echo htmlspecialchars($row['title']); ?></h5>
						<p class="card-text text-secondary small" style="line-height: 1.5; min-height: 45px;">
							<?php echo htmlspecialchars($row['description']); ?>
						</p>
						<a href="<?php echo $row['link']; ?>" target="_blank" class="btn btn-link text-primary text-decoration-none p-0 fw-semibold">
							View Project <i class="fas fa-arrow-right ms-1"></i>
						</a>
						
						<div class="d-flex justify-content-between mt-3 pt-3 border-top">
							<a href="projectsupdate.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm rounded-pill px-3">
								<i class="fas fa-edit me-1"></i>Edit
							</a>
							<a href="projectsdelete.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm rounded-pill px-3" onclick="return confirm('Remove this project?')">
								<i class="fas fa-trash me-1"></i>Delete
							</a>
						</div>
					</div>
				</div>
			</div>
			<?php 
				endwhile;
			} else {
			?>
			<div class="col-12">
				<div class="text-center py-5">
					<i class="fas fa-folder-open fa-4x text-muted mb-3"></i>
					<h5 class="text-muted">No projects found</h5>
					<p class="text-muted">Click "New Project" to add your first project.</p>
				</div>
			</div>
			<?php } ?>
		</div>
	</div>
</div>

<style>
.transition-all:hover {
	transform: translateY(-5px);
	box-shadow: 0 1rem 2rem rgba(0,0,0,0.1) !important;
}
.object-fit-cover {
	object-fit: cover;
}
</style>

<?php
	include('includes/footer.php');
?>