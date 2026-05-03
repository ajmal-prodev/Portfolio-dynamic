<?php 
	define('PAGE','DASHBOARD'); 
	define('TITLE','DASHBOARD');
	include('includes/header.php');
    include('../dbConnection.php');
	
	// Database connection
	// $host = "localhost";
	// $user = "root";
	// $pass = "";
	// $db   = "portfolio_db";

	// $conn = new mysqli($host, $user, $pass, $db);

	// LOGIC: Update theme values when a button is clicked
	if(isset($_POST['submit_theme'])) {
		$hue = intval($_POST['theme_hue']);
		$saturation = intval($_POST['theme_saturation']);
		$lightness = intval($_POST['theme_lightness']);
		
		// Update the active theme with new 3 values
		$update_query = "UPDATE themes SET hue_value = $hue, first_color_saturation = $saturation, first_color_lightness = $lightness WHERE is_active = 1";
		
		if($conn->query($update_query) === TRUE) {
			echo "<script>alert('Theme updated successfully!'); window.location.href='dashboard.php';</script>";
		} else {
			echo "<script>alert('Error updating theme: " . $conn->error . "');</script>";
		}
		exit();
	}

	// Fetch current active theme values
	$current_query = $conn->query("SELECT * FROM themes WHERE is_active = 1 LIMIT 1");
	$current_theme = $current_query->fetch_assoc();
	
	// If no active theme exists, create default
	if(!$current_theme) {
		$conn->query("INSERT INTO themes (hue_value, first_color_saturation, first_color_lightness, is_active) VALUES (180, 80, 48, 1)");
		$current_query = $conn->query("SELECT * FROM themes WHERE is_active = 1 LIMIT 1");
		$current_theme = $current_query->fetch_assoc();
	}
?>

<div class="col-sm-9 col-md-10 maincontentheight px-2 py-5">
    <h1 class="text-center">DASHBOARD - Theme Manager</h1>
    
    <div class="theme-container" style="background: <?php echo ($atheme == 'dark') ? '#1e293b' : '#ffffff'; ?>; padding: 2rem; border-radius: 1rem; text-align: center; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
        <h2 style="color: <?php echo ($atheme == 'dark') ? '#ffffff' : '#333333'; ?>; margin-bottom: 1.5rem;">Select Website Theme</h2>
        
        <div class="grid-buttons" style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 1rem; margin-top: 1.5rem;">
            <!-- Cyan Theme -->
            <form method="POST" style="margin: 0;">
                <input type="hidden" name="theme_hue" value="180">
                <input type="hidden" name="theme_saturation" value="80">
                <input type="hidden" name="theme_lightness" value="48">
                <button type="submit" name="submit_theme" class="theme-btn btn-Cyan" style="width: 100%; padding: 1rem; border: none; border-radius: .5rem; cursor: pointer; font-weight: bold; transition: transform 0.2s; background: hsl(180, 80%, 48%); color: white;">Cyan</button>
            </form>
            
            <!-- Blue Theme -->
            <form method="POST" style="margin: 0;">
                <input type="hidden" name="theme_hue" value="220">
                <input type="hidden" name="theme_saturation" value="90">
                <input type="hidden" name="theme_lightness" value="64">
                <button type="submit" name="submit_theme" class="theme-btn btn-Blue" style="width: 100%; padding: 1rem; border: none; border-radius: .5rem; cursor: pointer; font-weight: bold; transition: transform 0.2s; background: hsl(220, 90%, 64%); color: white;">Blue</button>
            </form>
            
            <!-- Pink Theme -->
            <form method="POST" style="margin: 0;">
                <input type="hidden" name="theme_hue" value="300">
                <input type="hidden" name="theme_saturation" value="70">
                <input type="hidden" name="theme_lightness" value="64">
                <button type="submit" name="submit_theme" class="theme-btn btn-Pink" style="width: 100%; padding: 1rem; border: none; border-radius: .5rem; cursor: pointer; font-weight: bold; transition: transform 0.2s; background: hsl(300, 70%, 64%); color: white;">Pink</button>
            </form>
            
            <!-- Green Theme -->
            <form method="POST" style="margin: 0;">
                <input type="hidden" name="theme_hue" value="110">
                <input type="hidden" name="theme_saturation" value="70">
                <input type="hidden" name="theme_lightness" value="64">
                <button type="submit" name="submit_theme" class="theme-btn btn-Green" style="width: 100%; padding: 1rem; border: none; border-radius: .5rem; cursor: pointer; font-weight: bold; transition: transform 0.2s; background: hsl(110, 70%, 64%); color: white;">Green</button>
            </form>
            
            <!-- Purple Theme -->
            <form method="POST" style="margin: 0;">
                <input type="hidden" name="theme_hue" value="255">
                <input type="hidden" name="theme_saturation" value="70">
                <input type="hidden" name="theme_lightness" value="64">
                <button type="submit" name="submit_theme" class="theme-btn btn-Purple" style="width: 100%; padding: 1rem; border: none; border-radius: .5rem; cursor: pointer; font-weight: bold; transition: transform 0.2s; background: hsl(255, 70%, 64%); color: white;">Purple</button>
            </form>
            
            <!-- Orange Theme -->
            <form method="POST" style="margin: 0;">
                <input type="hidden" name="theme_hue" value="15">
                <input type="hidden" name="theme_saturation" value="80">
                <input type="hidden" name="theme_lightness" value="64">
                <button type="submit" name="submit_theme" class="theme-btn btn-Orange" style="width: 100%; padding: 1rem; border: none; border-radius: .5rem; cursor: pointer; font-weight: bold; transition: transform 0.2s; background: hsl(15, 80%, 64%); color: white;">Orange</button>
            </form>
        </div>
        
        <div class="current-theme" style="margin-top: 20px; padding: 15px; background: <?php echo ($atheme == 'dark') ? '#0f172a' : '#f8f9fa'; ?>; border-radius: 8px; text-align: left; color: <?php echo ($atheme == 'dark') ? '#ffffff' : '#333333'; ?>;">
            <strong>Current Active Theme Values:</strong><br>
            🎨 Hue: <?php echo $current_theme['hue_value']; ?>°<br>
            🎨 Saturation: <?php echo $current_theme['first_color_saturation']; ?>%<br>
            🎨 Lightness: <?php echo $current_theme['first_color_lightness']; ?>%
        </div>
        
        <div class="preview-box" style="margin-top: 20px; padding: 15px; background: <?php echo ($atheme == 'dark') ? '#0f172a' : '#f8f9fa'; ?>; border-radius: 8px; text-align: center;">
            <strong style="color: <?php echo ($atheme == 'dark') ? '#ffffff' : '#333333'; ?>;">Color Preview:</strong><br>
            <div style="margin-top: 10px; display: flex; gap: 10px; justify-content: center;">
                <div style="width: 50px; height: 50px; background: hsl(<?php echo $current_theme['hue_value']; ?>, <?php echo $current_theme['first_color_saturation']; ?>%, <?php echo $current_theme['first_color_lightness']; ?>%); border-radius: 8px;"></div>
                <div style="width: 50px; height: 50px; background: hsl(<?php echo $current_theme['hue_value']; ?>, <?php echo $current_theme['first_color_saturation']+10; ?>%, <?php echo $current_theme['first_color_lightness']-4; ?>%); border-radius: 8px;"></div>
                <div style="width: 50px; height: 50px; background: hsl(<?php echo $current_theme['hue_value']; ?>, 8%, 92%); border-radius: 8px;"></div>
            </div>
            <p style="margin-top: 10px; font-size: 12px; color: <?php echo ($atheme == 'dark') ? '#94a3b8' : '#666666'; ?>;">Primary | Primary Alt | White</p>
        </div>
    </div>
</div>

<style>
    .theme-btn:hover {
        transform: scale(1.05);
        opacity: 0.9;
    }
    
    .grid-buttons form {
        margin: 0;
    }
    
    .btn-Cyan { background: hsl(180, 80%, 48%); color: white; }
    .btn-Blue { background: hsl(220, 90%, 64%); color: white; }
    .btn-Pink { background: hsl(300, 70%, 64%); color: white; }
    .btn-Green { background: hsl(110, 70%, 64%); color: white; }
    .btn-Purple { background: hsl(255, 70%, 64%); color: white; }
    .btn-Orange { background: hsl(15, 80%, 64%); color: white; }
</style>

<?php
	include('includes/footer.php');
?>


