<?php
// Start session if needed
session_start();
include('dbConnection.php');
?>

<!--==================== HOME ====================-->
<section class="home section" id="home">
    <?php
    // Fetch the latest home record from database
    $query = "SELECT * FROM home ORDER BY id DESC LIMIT 1";
    $result = $conn->query($query);
    
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        
        // Decode JSON designations
        $designations = json_decode($row['designation'], true);
        if (!is_array($designations)) {
            $designations = !empty($row['designation']) ? [$row['designation']] : [];
        }
        
        // Get image path
        $imgPath = !empty($row['image']) && file_exists("uploads/" . $row['image']) 
            ? "uploads/" . htmlspecialchars($row['image']) 
            : "ASSETS/IMAGES/home-profile.jpg";
        
        // Get resume path
        $resumePath = !empty($row['resume']) && file_exists("uploads/" . $row['resume']) 
            ? "uploads/" . $row['resume'] 
            : "";
    } else {
        // No data in database - show empty/placeholder
        $row = null;
        $designations = [];
        $imgPath = "ASSETS/IMAGES/home-profile.jpg";
        $resumePath = "";
    }
    
    // Convert designations to JSON for JavaScript
    $designationsJson = json_encode($designations);
    ?>
    
    <div class="home__container container grid">
        <div class="home__content">
            <div class="home__image">
                <img src="<?php echo $imgPath; ?>" alt="Profile image" class="home__img">
            </div>
            <div class="home__social">
                <?php if($row && !empty($row['linkedin'])): ?>
                    <a href="<?php echo htmlspecialchars($row['linkedin']); ?>" target="_blank" class="home__link">
                        <i class="bi-linkedin"></i>
                    </a>
                <?php else: ?>
                    <a href="#" target="_blank" class="home__link">
                        <i class="bi-linkedin"></i>
                    </a>
                <?php endif; ?>
                
                <?php if($row && !empty($row['github'])): ?>
                    <a href="<?php echo htmlspecialchars($row['github']); ?>" target="_blank" class="home__link">
                        <i class="bi-github"></i>
                    </a>
                <?php else: ?>
                    <a href="#" target="_blank" class="home__link">
                        <i class="bi-github"></i>
                    </a>
                <?php endif; ?>
                
                <?php if($row && !empty($row['instagram'])): ?>
                    <a href="<?php echo htmlspecialchars($row['instagram']); ?>" target="_blank" class="home__link">
                        <i class="bi-instagram"></i>
                    </a>
                <?php else: ?>
                    <a href="#" target="_blank" class="home__link">
                        <i class="bi-dribbble"></i>
                    </a>
                <?php endif; ?>
            </div>
        </div>

        <div class="home__data grid">
            <p class="home__subtitle">
                Hi, I'm a <span id="home-typed"></span>
            </p>
            <h1 class="home__title">
                <?php echo $row ? htmlspecialchars($row['name']) : ''; ?>
            </h1>

            <p class="home__description">
                <?php echo $row ? htmlspecialchars(trim($row['description'])) : ''; ?>
            </p>

            <div class="home__buttons">
                <?php if(!empty($resumePath)): ?>
                    <a href="<?php echo $resumePath; ?>" download="" target="_blank" class="button">Download CV</a>
                <?php endif; ?>
                <a href="#projects" class="button button__ghost">Projects</a>
            </div>
        </div>
    </div>
</section>

<script>
// Override the existing Typed.js initialization with database values
document.addEventListener('DOMContentLoaded', function() {
    // Get designations from PHP
    const designations = <?php echo $designationsJson; ?>;
    
    // Check if typed element exists and designations are available
    const typedElement = document.getElementById('home-typed');
    
    if (typedElement && designations && designations.length > 0) {
        // Clear the existing Typed instance if it exists
        if (window.typedInstance) {
            window.typedInstance.destroy();
        }
        
        // Clear the span content
        typedElement.innerHTML = '';
        
        // Create new Typed instance
        window.typedInstance = new Typed('#home-typed', {
            strings: designations,
            typeSpeed: 80,
            backSpeed: 40,
            backDelay: 2000,
            loop: true,
            cursorChar: '_',
            startDelay: 300
        });
    } else if (typedElement) {
        // If no designations in database, leave it empty or show placeholder
        typedElement.innerHTML = '';
    }
});
</script>