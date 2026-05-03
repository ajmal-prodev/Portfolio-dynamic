<?php 
	define('PAGE','CONTACT'); 
	define('TITLE','CONTACTADD');
	include('includes/header.php');
    include('../dbConnection.php');
    
    // Fetch existing data
    $res = $conn->query("SELECT * FROM contact WHERE id=1");
    $data = $res->fetch_assoc();
    $saved_hours = json_decode($data['availability'] ?? '{}', true);
    
    if (isset($_POST['submit'])) {
        $gmail = mysqli_real_escape_string($conn, $_POST['gmail']);
        $phone = mysqli_real_escape_string($conn, $_POST['phone']);
        $loc = mysqli_real_escape_string($conn, $_POST['location']);
        $wa = mysqli_real_escape_string($conn, $_POST['whatsapp']);
        $ig = mysqli_real_escape_string($conn, $_POST['instagram']);
        $tg = mysqli_real_escape_string($conn, $_POST['telegram']);
        
        // Process Availability
        $availability = json_encode($_POST['hours']);
    
        $sql = "INSERT INTO contact (id, gmail, phone, location, availability, whatsapp, instagram, telegram) 
                VALUES (1, '$gmail', '$phone', '$loc', '$availability', '$wa', '$ig', '$tg')
                ON DUPLICATE KEY UPDATE 
                gmail='$gmail', phone='$phone', location='$loc', availability='$availability', 
                whatsapp='$wa', instagram='$ig', telegram='$tg'";
    
        if ($conn->query($sql)) {
            echo "<script>alert('Contact information updated successfully!'); location.href='contactview.php';</script>";
            exit();
        } else {
            echo "<script>alert('Error updating information: " . $conn->error . "');</script>";
        }
    }
?>

<div class="col-sm-9 col-md-10 maincontentheight px-2 py-5">
	<h1 class="text-center mb-4">Contact & Availability Settings</h1>
	
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-lg-10">
				<div class="card shadow-sm border-0 rounded-4">
					<div class="card-body p-4">
						<form method="POST">
							<div class="row">
								<div class="col-md-6 mb-3">
									<label class="form-label fw-semibold">Gmail *</label>
									<input type="email" name="gmail" class="form-control" value="<?php echo $data['gmail'] ?? ''; ?>" required>
								</div>
								<div class="col-md-6 mb-3">
									<label class="form-label fw-semibold">Phone</label>
									<input type="text" name="phone" class="form-control" value="<?php echo $data['phone'] ?? ''; ?>">
								</div>
								<div class="col-md-6 mb-3">
									<label class="form-label fw-semibold">Location</label>
									<input type="text" name="location" class="form-control" value="<?php echo $data['location'] ?? ''; ?>">
								</div>
								<div class="col-md-6 mb-3">
									<label class="form-label fw-semibold">WhatsApp</label>
									<input type="text" name="whatsapp" class="form-control" value="<?php echo $data['whatsapp'] ?? ''; ?>" placeholder="Enter WhatsApp number">
								</div>
								<div class="col-md-6 mb-3">
									<label class="form-label fw-semibold">Instagram</label>
									<input type="text" name="instagram" class="form-control" value="<?php echo $data['instagram'] ?? ''; ?>" placeholder="Instagram username">
								</div>
								<div class="col-md-6 mb-3">
									<label class="form-label fw-semibold">Telegram</label>
									<input type="text" name="telegram" class="form-control" value="<?php echo $data['telegram'] ?? ''; ?>" placeholder="Telegram username">
								</div>
							</div>
							
							<div class="mt-4 pt-2 border-top">
								<h5 class="mb-3">Weekly Schedule (AM/PM)</h5>
								<?php 
								$days = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
								foreach($days as $day): 
									$is_holiday = isset($saved_hours[$day]['holiday']);
									$start = $saved_hours[$day]['start'] ?? '09:00';
									$end = $saved_hours[$day]['end'] ?? '17:00';
								?>
								<div class="row mb-2 align-items-center <?php echo $is_holiday ? 'bg-danger bg-opacity-10 rounded p-2' : ''; ?>" id="row-<?php echo $day; ?>">
									<div class="col-md-2">
										<strong class="fw-bold"><?php echo $day; ?></strong>
									</div>
									<div class="col-md-3">
										<div class="form-check">
											<input type="checkbox" class="form-check-input" name="hours[<?php echo $day; ?>][holiday]" value="1" id="holiday-<?php echo $day; ?>" <?php echo $is_holiday ? 'checked' : ''; ?> onchange="updateRow('<?php echo $day; ?>')">
											<label class="form-check-label text-danger" for="holiday-<?php echo $day; ?>">Holiday / Closed</label>
										</div>
									</div>
									<div class="col-md-3">
										<input type="time" class="form-control" name="hours[<?php echo $day; ?>][start]" id="start-<?php echo $day; ?>" value="<?php echo $start; ?>" <?php echo $is_holiday ? 'disabled' : ''; ?>>
									</div>
									<div class="col-md-3">
										<input type="time" class="form-control" name="hours[<?php echo $day; ?>][end]" id="end-<?php echo $day; ?>" value="<?php echo $end; ?>" <?php echo $is_holiday ? 'disabled' : ''; ?>>
									</div>
									<div class="col-md-1">
										<span class="text-muted small">to</span>
									</div>
								</div>
								<?php endforeach; ?>
							</div>
							
							<div class="d-flex gap-3 mt-4">
								<button type="submit" name="submit" class="btn btn-primary px-4 py-2 rounded-pill">Update Information</button>
								<a href="contactview.php" class="btn btn-secondary px-4 py-2 rounded-pill">Cancel</a>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
	function updateRow(day) {
		const check = document.querySelector(`input[name="hours[${day}][holiday]"]`);
		const start = document.getElementById(`start-${day}`);
		const end = document.getElementById(`end-${day}`);
		const row = document.getElementById(`row-${day}`);

		if (check.checked) {
			start.disabled = true;
			end.disabled = true;
			row.classList.add('bg-danger', 'bg-opacity-10', 'rounded', 'p-2');
		} else {
			start.disabled = false;
			end.disabled = false;
			row.classList.remove('bg-danger', 'bg-opacity-10', 'rounded', 'p-2');
		}
	}
</script>

<?php
	include('includes/footer.php');
?>