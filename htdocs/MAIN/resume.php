<?php
include('dbConnection.php');
?>

<!--==================== RESUME ====================-->
<section class="resume section container" id="resume">
   <h2 class="section__title">My Resume</h2>

   <div class="resume__container container grid">
      
      <?php 
      // Fetch Experience Data from Database
      $exp_query = "SELECT * FROM resume_experience ORDER BY start_date DESC";
      $exp_result = $conn->query($exp_query);
      
      $experiences = [];
      if ($exp_result && $exp_result->num_rows > 0) {
          while($row = $exp_result->fetch_assoc()) {
              $experiences[] = [
                  'id' => $row['id'],
                  'title' => $row['designation'],
                  'company' => $row['company'],
                  'period' => ($row['end_date'] == '0000-00-00' || empty($row['end_date'])) 
                      ? date("M Y", strtotime($row['start_date'])) . " — Present" 
                      : date("M Y", strtotime($row['start_date'])) . " — " . date("M Y", strtotime($row['end_date'])),
                  'description' => $row['description']
              ];
          }
      }
      
      // Fetch Education Data from Database
      $edu_query = "SELECT * FROM resume_education ORDER BY start_date DESC";
      $edu_result = $conn->query($edu_query);
      
      $educations = [];
      if ($edu_result && $edu_result->num_rows > 0) {
          while($row = $edu_result->fetch_assoc()) {
              $educations[] = [
                  'id' => $row['id'],
                  'title' => $row['degree'],
                  'institution' => $row['institution'],
                  'period' => date("M Y", strtotime($row['start_date'])) . " — " . date("M Y", strtotime($row['end_date'])),
                  'description' => $row['description']
              ];
          }
      }
      ?>

      <!-- LEFT COLUMN - EXPERIENCE -->
      <div class="resume__content">
         <h2 class="resume__subtitle">
            <i class="bi bi-award-fill"></i>
            <span class="experience-subtitle">Experience</span>
         </h2>

         <div class="resume__list">
            <?php if(!empty($experiences)): ?>
                <?php foreach($experiences as $exp): ?>
                <div class="resume__data">
                   <h3 class="resume__title"><?php echo htmlspecialchars($exp['title']); ?></h3>
                   <div class="resume__info">
                      <address><?php echo htmlspecialchars($exp['company']); ?></address>
                      <address><?php echo htmlspecialchars($exp['period']); ?></address>
                   </div>
                   <p class="resume__description"><?php echo nl2br(htmlspecialchars($exp['description'])); ?></p>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="resume__data">
                   <p class="resume__description text-muted">No work experience added yet.</p>
                </div>
            <?php endif; ?>
         </div>
      </div>

      <!-- RIGHT COLUMN - EDUCATION -->
      <div class="resume__content">
         <h2 class="resume__subtitle">
            <i class="bi bi-mortarboard-fill"></i>
            <span>Education</span>
         </h2>

         <div class="resume__list">
            <?php if(!empty($educations)): ?>
                <?php foreach($educations as $edu): ?>
                <div class="resume__data">
                   <h3 class="resume__title"><?php echo htmlspecialchars($edu['title']); ?></h3>
                   <div class="resume__info">
                      <address><?php echo htmlspecialchars($edu['institution']); ?></address>
                      <address><?php echo htmlspecialchars($edu['period']); ?></address>
                   </div>
                   <p class="resume__description"><?php echo nl2br(htmlspecialchars($edu['description'])); ?></p>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="resume__data">
                   <p class="resume__description text-muted">No education added yet.</p>
                </div>
            <?php endif; ?>
         </div>
      </div>

   </div>
</section>