<?php 
	define('PAGE','CONTACT'); 
	define('TITLE','CONTACT');
	include('includes/header.php');
    include('../dbConnection.php');
    
    // Fetch existing data
    $res = $conn->query("SELECT * FROM contact WHERE id=1");
    $row = $res->fetch_assoc();
    $hours = json_decode($row['availability'] ?? '{}', true);
?>

<div class="col-sm-9 col-md-10 maincontentheight px-2 py-5">
	<h1 class="text-center mb-4">Contact Information</h1>
	
	<div class="container">
		<div class="row">
			<div class="col-lg-6 mb-4">
				<div class="card shadow-sm border-0 rounded-4 h-100">
					<div class="card-body p-4">
						<h4 class="mb-4">Contact Info</h4>
						<div class="contact-item d-flex align-items-center mb-3">
							<div class="bg-primary bg-opacity-10 rounded-circle p-3 me-3">
								<i class="fas fa-envelope text-primary"></i>
							</div>
							<div>
								<small class="text-muted d-block">Email</small>
								<span class="fw-semibold"><?php echo $row['gmail'] ?? 'Not set'; ?></span>
							</div>
						</div>
						
						<div class="contact-item d-flex align-items-center mb-3">
							<div class="bg-primary bg-opacity-10 rounded-circle p-3 me-3">
								<i class="fas fa-phone text-primary"></i>
							</div>
							<div>
								<small class="text-muted d-block">Phone</small>
								<span class="fw-semibold"><?php echo $row['phone'] ?? 'Not set'; ?></span>
							</div>
						</div>
						
						<div class="contact-item d-flex align-items-center mb-3">
							<div class="bg-primary bg-opacity-10 rounded-circle p-3 me-3">
								<i class="fas fa-map-marker-alt text-primary"></i>
							</div>
							<div>
								<small class="text-muted d-block">Location</small>
								<span class="fw-semibold"><?php echo $row['location'] ?? 'Not set'; ?></span>
							</div>
						</div>
						
						<hr class="my-4">
						
						<h5 class="mb-3">Social Connections</h5>
						<div class="d-flex gap-3">
							<?php if(!empty($row['whatsapp'])): ?>
								<a href="https://wa.me/<?php echo $row['whatsapp']; ?>" target="_blank" class="btn btn-success rounded-circle p-3" style="width: 50px; height: 50px;">
									<i class="fab fa-whatsapp"></i>
								</a>
							<?php endif; ?>
							<?php if(!empty($row['instagram'])): ?>
								<a href="https://instagram.com/<?php echo $row['instagram']; ?>" target="_blank" class="btn btn-danger rounded-circle p-3" style="width: 50px; height: 50px;">
									<i class="fab fa-instagram"></i>
								</a>
							<?php endif; ?>
							<?php if(!empty($row['telegram'])): ?>
								<a href="https://t.me/<?php echo $row['telegram']; ?>" target="_blank" class="btn btn-info rounded-circle p-3" style="width: 50px; height: 50px;">
									<i class="fab fa-telegram"></i>
								</a>
							<?php endif; ?>
						</div>
						
						<div class="mt-4">
							<a href="contactadd.php" class="btn btn-primary rounded-pill px-4">Edit Settings</a>
						</div>
					</div>
				</div>
			</div>
			
			<div class="col-lg-6 mb-4">
				<div class="card shadow-sm border-0 rounded-4 h-100">
					<div class="card-body p-4">
						<h4 class="mb-4">Weekly Availability</h4>
						<ul class="list-unstyled">
							<?php 
							$days = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
							foreach($days as $d): 
							?>
							<li class="d-flex justify-content-between align-items-center py-2 border-bottom">
								<strong class="fw-bold"><?php echo $d; ?></strong>
								<span>
									<?php if(isset($hours[$d]['holiday'])): ?>
										<span class="badge bg-danger rounded-pill px-3 py-2">Holiday / Closed</span>
									<?php else: ?>
										<span class="badge bg-success rounded-pill px-3 py-2">
											<?php 
											$start = $hours[$d]['start'] ?? '09:00';
											$end = $hours[$d]['end'] ?? '17:00';
											echo date("g:i A", strtotime($start)); ?> - 
											<?php echo date("g:i A", strtotime($end)); 
											?>
										</span>
									<?php endif; ?>
								</span>
							</li>
							<?php endforeach; ?>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php
	include('includes/footer.php');
?>