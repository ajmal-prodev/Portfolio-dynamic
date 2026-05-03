<?php 
	define('PAGE','SERVICES'); 
	define('TITLE','SERVICES');
	include('includes/header.php');
    include('../dbConnection.php');
?>

<div class="col-sm-9 col-md-10 maincontentheight px-2 py-5">
	<div class="container-fluid px-0">
		<div class="d-flex justify-content-between align-items-center mb-4">
			<h1 class="mb-0">What I Do</h1>
			<a href="servicesadd.php" class="btn btn-primary rounded-pill px-4">
				<i class="fas fa-plus me-2"></i>New Service
			</a>
		</div>
		
		<p class="text-muted mb-4">Professional services tailored to your needs</p>
		
		<div class="row">
			<?php
			$res = $conn->query("SELECT * FROM services ORDER BY id DESC");
			if($res && $res->num_rows > 0) {
				while($row = $res->fetch_assoc()):
			?>
			<div class="col-md-6 col-lg-4 mb-4">
				<div class="card shadow-sm border-0 rounded-4 h-100 text-center transition-all" style="transition: transform 0.3s;">
					<div class="card-body p-4">
						<div class="mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 80px; height: 80px; background: #eef2ff; border-radius: 50%;">
							<i class="<?php echo htmlspecialchars($row['icon_class']); ?> fa-2x" style="color: #4834d4;"></i>
						</div>
						<h5 class="card-title fw-bold mb-3"><?php echo htmlspecialchars($row['designation']); ?></h5>
						<p class="card-text text-secondary small" style="line-height: 1.6; min-height: 70px;">
							<?php echo htmlspecialchars($row['description']); ?>
						</p>
						<?php if(!empty($row['link'])): ?>
							<a href="<?php echo $row['link']; ?>" target="_blank" class="btn btn-link text-primary text-decoration-none p-0 fw-semibold">
								Get Started <i class="fas fa-arrow-right ms-1"></i>
							</a>
						<?php endif; ?>
						
						<div class="d-flex justify-content-center gap-3 mt-3 pt-3 border-top">
							<a href="servicesupdate.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm rounded-pill px-3">
								<i class="fas fa-edit me-1"></i>Edit
							</a>
							<a href="servicesdelete.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm rounded-pill px-3" onclick="return confirm('Remove this service?')">
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
					<i class="fas fa-cogs fa-4x text-muted mb-3"></i>
					<h5 class="text-muted">No services added yet</h5>
					<p class="text-muted">Click "New Service" to add your first service.</p>
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
</style>

<?php
	include('includes/footer.php');
?>