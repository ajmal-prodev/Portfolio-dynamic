<?php 
	define('PAGE','HOME'); 
	define('TITLE','HOME');
	include('includes/header.php');
    include('../dbConnection.php');
?>

<div class="col-sm-9 col-md-10 maincontentheight px-2 py-5">
	<h1 class="text-center mb-4">HOME - Portfolio Records</h1>
	
	<!-- Portfolio Records Display Area -->
	<div class="container-fluid px-0">
		<div class="d-flex justify-content-end mb-3">
			<a href="homeadd.php" class="btn btn-success rounded-pill px-4">+ Create Profile</a>
		</div>

		<div class="table-responsive">
			<table class="table table-borderless">
				<thead class="text-secondary text-uppercase small">
					<tr>
						<th>Profile</th>
						<th style="width: 45%;">Personal & Portfolio Info</th>
						<th>Documents</th>
						<th>Connections</th>
						<th>Manage</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$query = "SELECT * FROM home ORDER BY id DESC";
					$result = $conn->query($query);

					if($result && $result->num_rows > 0) {
						while($row = $result->fetch_assoc()): 
							// Decode JSON designations
							$designations = json_decode($row['designation'], true);
							if (!is_array($designations)) {
								$designations = !empty($row['designation']) ? [$row['designation']] : [];
							}
						?>
						<tr class="bg-white shadow-sm rounded-lg" style="border-radius:12px; transition:transform 0.2s;">
							<td class="align-middle" style="border-radius:12px 0 0 12px;">
								<div class="position-relative" style="width:80px; height:80px;">
									<?php 
									// Correct path: uploads folder is at same level as admin folder
									$imgPath = "../uploads/" . htmlspecialchars($row['image']);
									if (file_exists($imgPath)) {
										echo '<img src="'.$imgPath.'" class="img-fluid rounded-3 shadow-sm" style="width:100%; height:100%; object-fit:cover;">';
									} else {
										echo '<img src="https://via.placeholder.com/80" class="img-fluid rounded-3 shadow-sm" style="width:100%; height:100%; object-fit:cover;">';
									}
									?>
								</div>
							</td>
							<td class="align-middle">
								<div class="mb-2">
									<strong class="fs-5 text-dark"><?php echo htmlspecialchars($row['name']); ?></strong><br>
									<div class="mt-1">
										<?php 
										if(!empty($designations)) {
											foreach($designations as $desig) {
												echo '<span class="badge bg-primary me-1 mb-1 px-3 py-2 rounded-pill">' . htmlspecialchars($desig) . '</span>';
											}
										} else {
											echo '<span class="text-muted">No designation</span>';
										}
										?>
									</div>
								</div>
								<div class="text-secondary small" style="line-height:1.5; white-space:pre-line;">
									<?php echo trim(htmlspecialchars($row['description'])); ?>
								</div>
							</td>
							<td class="align-middle">
								<?php if(!empty($row['resume'])): ?>
									<?php 
									$resumePath = "../uploads/" . $row['resume'];
									if (file_exists($resumePath)) {
										echo '<a href="'.$resumePath.'" target="_blank" class="btn btn-sm btn-warning rounded-pill">📄 View Resume</a>';
									} else {
										echo '<span class="text-danger">File not found</span>';
									}
									?>
								<?php else: ?>
									<span class="text-muted">No PDF</span>
								<?php endif; ?>
							</td>
							<td class="align-middle">
								<div class="d-flex flex-column gap-2">
									<?php if($row['linkedin']) echo "<a href='".$row['linkedin']."' class='btn btn-sm' style='background:#0077b5; color:white; width:100px;' target='_blank'>LinkedIn</a>"; ?>
									<?php if($row['github']) echo "<a href='".$row['github']."' class='btn btn-sm' style='background:#2f3542; color:white; width:100px;' target='_blank'>GitHub</a>"; ?>
									<?php if($row['instagram']) echo "<a href='".$row['instagram']."' class='btn btn-sm' style='background:#e1306c; color:white; width:100px;' target='_blank'>Instagram</a>"; ?>
								</div>
							</td>
							<td class="align-middle" style="border-radius:0 12px 12px 0;">
								<div class="d-flex gap-3">
									<a href="homeupdate.php?id=<?php echo $row['id']; ?>" class="text-warning text-decoration-none fw-semibold">Edit</a>
									<a href="homedelete.php?id=<?php echo $row['id']; ?>" class="text-danger text-decoration-none fw-semibold" onclick="return confirm('Delete this record?')">Delete</a>
								</div>
							</td>
						</tr>
						<?php endwhile; 
					} else { ?>
						<tr>
							<td colspan="5" class="text-center py-5 text-muted">
								No data found. Click "Create Profile" to start.
							</td>
						</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
	</div>
	<!-- End Portfolio Records Display Area -->
	
</div>

<?php
	include('includes/footer.php');
?>