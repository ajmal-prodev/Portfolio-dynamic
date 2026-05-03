<?php 
	define('PAGE','FOOTER'); 
	define('TITLE','FOOTER');
	include('includes/header.php');
    include('../dbConnection.php');
    
    // Fetch current data
    $res = $conn->query("SELECT * FROM footer WHERE id=1");
    $data = $res->fetch_assoc();
?>

<div class="col-sm-9 col-md-10 maincontentheight px-2 py-5">
	<h1 class="text-center mb-4">Footer Settings</h1>
	
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-lg-8">
				<div class="card shadow-sm border-0 rounded-4 mb-4">
					<div class="card-body p-4">
						<h4 class="mb-4">Current Footer Preview</h4>
						
						<div class="bg-dark text-white rounded-3 p-4 text-center" style="background: #111;">
							<div class="mb-3">
								<div class="d-flex justify-content-center gap-4 flex-wrap">
									<?php if(!empty($data['facebook'])): ?>
										<a href="<?php echo $data['facebook']; ?>" target="_blank" class="text-white text-decoration-none fs-3 opacity-75 hover-opacity-100" style="transition: 0.3s;">
											<i class="fab fa-facebook"></i>
										</a>
									<?php endif; ?>
									
									<?php if(!empty($data['instagram'])): ?>
										<a href="<?php echo $data['instagram']; ?>" target="_blank" class="text-white text-decoration-none fs-3 opacity-75 hover-opacity-100" style="transition: 0.3s;">
											<i class="fab fa-instagram"></i>
										</a>
									<?php endif; ?>
									
									<?php if(!empty($data['twitter_x'])): ?>
										<a href="<?php echo $data['twitter_x']; ?>" target="_blank" class="text-white text-decoration-none fs-3 opacity-75 hover-opacity-100" style="transition: 0.3s;">
											<i class="fab fa-twitter"></i>
										</a>
									<?php endif; ?>
									
									<?php if(!empty($data['youtube'])): ?>
										<a href="<?php echo $data['youtube']; ?>" target="_blank" class="text-white text-decoration-none fs-3 opacity-75 hover-opacity-100" style="transition: 0.3s;">
											<i class="fab fa-youtube"></i>
										</a>
									<?php endif; ?>
									
									<?php if(empty($data['facebook']) && empty($data['instagram']) && empty($data['twitter_x']) && empty($data['youtube'])): ?>
										<p class="text-muted mb-0">No social links configured yet</p>
									<?php endif; ?>
								</div>
							</div>
							
							<p class="text-secondary mb-0 small">
								&copy; <?php echo date("Y"); ?> Portfolio. All Rights Reserved.
							</p>
						</div>
						
						<div class="mt-4 text-center">
							<a href="footeradd.php" class="btn btn-primary rounded-pill px-4">Edit Footer Links</a>
						</div>
					</div>
				</div>
				
				<div class="card shadow-sm border-0 rounded-4">
					<div class="card-body p-4">
						<h4 class="mb-3">Current Social Links</h4>
						<div class="table-responsive">
							<table class="table table-borderless">
								<tbody>
									<tr>
										<td class="fw-semibold" style="width: 120px;">Facebook:</td>
										<td><?php echo !empty($data['facebook']) ? '<a href="'.$data['facebook'].'" target="_blank">'.$data['facebook'].'</a>' : '<span class="text-muted">Not configured</span>'; ?></td>
									</tr>
									<tr>
										<td class="fw-semibold">Instagram:</td>
										<td><?php echo !empty($data['instagram']) ? '<a href="'.$data['instagram'].'" target="_blank">'.$data['instagram'].'</a>' : '<span class="text-muted">Not configured</span>'; ?></td>
									</tr>
									<tr>
										<td class="fw-semibold">Twitter (X):</td>
										<td><?php echo !empty($data['twitter_x']) ? '<a href="'.$data['twitter_x'].'" target="_blank">'.$data['twitter_x'].'</a>' : '<span class="text-muted">Not configured</span>'; ?></td>
									</tr>
									<tr>
										<td class="fw-semibold">YouTube:</td>
										<td><?php echo !empty($data['youtube']) ? '<a href="'.$data['youtube'].'" target="_blank">'.$data['youtube'].'</a>' : '<span class="text-muted">Not configured</span>'; ?></td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<style>
.hover-opacity-100:hover {
	opacity: 1 !important;
	transform: translateY(-3px);
}
.hover-opacity-100 {
	opacity: 0.75;
	transition: all 0.3s ease;
}
.fa-facebook:hover { color: #1877F2; }
.fa-instagram:hover { color: #E1306C; }
.fa-twitter:hover { color: #1DA1F2; }
.fa-youtube:hover { color: #FF0000; }
</style>

<?php
	include('includes/footer.php');
?>