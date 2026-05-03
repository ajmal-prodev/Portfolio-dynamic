<?php 
	define('PAGE','ABOUT'); 
	define('TITLE','ABOUT');
	include('includes/header.php');
    include('../dbConnection.php');
?>

<div class="col-sm-9 col-md-10 maincontentheight px-2 py-5">
	<h1 class="text-center mb-4">About Section - Profiles</h1>
	
	<div class="container-fluid px-0">
		<div class="d-flex justify-content-end mb-4">
			<a href="aboutadd.php" class="btn btn-success rounded-pill px-4">+ Add Profile</a>
		</div>
		
		<?php
		$res = $conn->query("SELECT * FROM about ORDER BY id DESC");
		while($row = $res->fetch_assoc()):
			$p_id = $row['id'];
			$img_path = "../uploads/" . $row['image'];
		?>
		<div class="card shadow-sm border-0 rounded-4 mb-4 overflow-hidden">
			<div class="row g-0">
				<div class="col-md-4" style="max-width: 300px;">
					<div class="h-100 bg-light d-flex align-items-center justify-content-center" style="min-height: 250px;">
						<?php if (!empty($row['image']) && file_exists($img_path)): ?>
							<img src="<?php echo $img_path; ?>?v=<?php echo time(); ?>" class="img-fluid h-100 w-100 object-fit-cover">
						<?php else: ?>
							<div class="text-muted">No Image Found</div>
						<?php endif; ?>
					</div>
				</div>
				<div class="col-md-8">
					<div class="card-body p-4">
						<div class="desc-text mb-3" style="line-height: 1.6; color: #444;">
							<?php echo htmlspecialchars($row['description']); ?>
						</div>
						
						<h6 class="fw-bold mb-2">Expertise:</h6>
						<div class="mb-3">
							<?php
							$s_res = $conn->query("SELECT skill_name FROM about_skills WHERE profile_id=$p_id");
							while($s = $s_res->fetch_assoc()): 
							?>
								<span class="badge bg-primary me-2 mb-2 px-3 py-2 rounded-pill"><?php echo htmlspecialchars($s['skill_name']); ?></span>
							<?php endwhile; ?>
						</div>
						
						<div class="actions mt-3 pt-2 border-top">
							<a href="aboutupdate.php?id=<?php echo $p_id; ?>" class="btn btn-warning btn-sm rounded-pill px-4 me-2">Edit</a>
							<a href="aboutdelete.php?id=<?php echo $p_id; ?>" class="btn btn-danger btn-sm rounded-pill px-4" onclick="return confirm('Delete this profile?')">Remove</a>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php endwhile; ?>
		
		<?php if($res->num_rows == 0): ?>
			<div class="text-center py-5 text-muted">
				No profiles found. Click "Add Profile" to create one.
			</div>
		<?php endif; ?>
	</div>
</div>

<?php
	include('includes/footer.php');
?>