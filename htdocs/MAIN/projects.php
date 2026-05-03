<?php
include('dbConnection.php');
?>

<!--==================== PROJECTS ====================-->
<section class="projects section" id="projects">
    <?php
    // Fetch all projects from database
    $query = "SELECT * FROM projects ORDER BY id DESC";
    $result = $conn->query($query);
    
    $projects = [];
    if ($result && $result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            // Get image path
            $imgPath = !empty($row['image']) && file_exists("uploads/" . $row['image']) 
                ? "uploads/" . htmlspecialchars($row['image']) 
                : "";
            
            $projects[] = [
                'id' => $row['id'],
                'title' => $row['title'],
                'description' => $row['description'],
                'image' => $imgPath,
                'link' => $row['link']
            ];
        }
    }
    ?>
    
    <h3 class="section__title">Projects</h3>
    
    <?php if(!empty($projects)): ?>
        <div class="projects__container container grid">
            <?php foreach($projects as $project): ?>
                <article class="projects__card">
                    <?php if(!empty($project['image'])): ?>
                        <img src="<?php echo $project['image']; ?>" alt="<?php echo htmlspecialchars($project['title']); ?>" class="projects__img">
                    <?php else: ?>
                        <img src="ASSETS/IMAGES/project-placeholder.jpg" alt="Project image" class="projects__img">
                    <?php endif; ?>
                    <div class="projects__data">
                        <h3 class="projects__title"><?php echo htmlspecialchars($project['title']); ?></h3>
                        <p class="projects__description"><?php echo htmlspecialchars($project['description']); ?></p>
                        <?php if(!empty($project['link'])): ?>
                            <a href="<?php echo htmlspecialchars($project['link']); ?>" target="_blank" class="button button__ghost">View Project</a>
                        <?php else: ?>
                            <a href="#" class="button button__ghost disabled">View Project</a>
                        <?php endif; ?>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="projects__container container">
            <div class="text-center py-5">
                <p class="text-muted">No projects found. Please add projects through the admin panel.</p>
            </div>
        </div>
    <?php endif; ?>
</section>