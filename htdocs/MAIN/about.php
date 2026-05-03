<?php

include('dbConnection.php');
?>

<!--==================== ABOUT ====================-->
<section class="about section" id="about">
    <?php
    // Fetch the latest about record from database
    $query = "SELECT * FROM about ORDER BY id DESC LIMIT 1";
    $result = $conn->query($query);
    
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $about_id = $row['id'];
        
        // Get image path - only from database
        $imgPath = !empty($row['image']) && file_exists("uploads/" . $row['image']) 
            ? "uploads/" . htmlspecialchars($row['image']) 
            : "ASSETS/IMAGES/about-profile.jpg"; // This is the only fallback for image
        
        // Get description - directly from database
        $description = !empty($row['description']) 
            ? htmlspecialchars(trim($row['description'])) 
            : ""; // Empty if no description in database
        
        // Fetch skills from about_skills table - only from database
        $skills_query = "SELECT skill_name FROM about_skills WHERE profile_id = $about_id ORDER BY id ASC";
        $skills_result = $conn->query($skills_query);
        $skills = [];
        if ($skills_result && $skills_result->num_rows > 0) {
            while($skill = $skills_result->fetch_assoc()) {
                $skills[] = $skill['skill_name'];
            }
        }
    } else {
        // No data in database - show nothing
        $row = null;
        $imgPath = "ASSETS/IMAGES/about-profile.jpg";
        $description = "";
        $skills = [];
    }
    ?>
    
    <div class="about__container container grid">
        <div class="about__content">
            <div class="about__data">
                <h2 class="section__title">About Me</h2>
                <p class="about__description">
                    <?php echo $description; ?>
                </p>

                <a href="#contact" class="button button__ghost">Contact Me</a>
            </div>

            <div class="about__skills">
                <h3 class="about__subtitle">
                    <i class="bi bi-bookmark-fill"></i>
                    <span>Skills</span>
                </h3>

                <ul class="about__items">
                    <?php if(!empty($skills)): ?>
                        <?php foreach($skills as $skill): ?>
                            <li class="about__item"><?php echo htmlspecialchars($skill); ?></li>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <!-- Show nothing if no skills in database -->
                    <?php endif; ?>
                </ul>
            </div>
        </div>
        <div class="about__image">
            <img src="<?php echo $imgPath; ?>" alt="About image" class="about__img">
        </div>
    </div>
</section>