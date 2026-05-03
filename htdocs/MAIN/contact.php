<?php
include('dbConnection.php');

// Fetch contact information from database
$query = "SELECT * FROM contact WHERE id = 1";
$result = $conn->query($query);
$contact = null;

if ($result && $result->num_rows > 0) {
    $contact = $result->fetch_assoc();
    // Decode availability JSON
    $availability = json_decode($contact['availability'] ?? '{}', true);
} else {
    $availability = [];
}

// Define days order
$days = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
?>

<!--==================== CONTACT ====================-->
<section class="contact section" id="contact">
    <h3 class="section__title">Contact Me</h3>

    <div class="contact__container container grid">
        <?php include('contactform.php'); ?>

        <div class="contact__content">
            <!-- EMAIL -->
            <?php if($contact && !empty($contact['gmail'])): ?>
            <div class="contact__info-item">
                <i class="bi bi-envelope-fill"></i>
                <span class="contact__info-text"><?php echo htmlspecialchars($contact['gmail']); ?></span>
            </div>
            <?php endif; ?>

            <!-- PHONE -->
            <?php if($contact && !empty($contact['phone'])): ?>
            <div class="contact__info-item">
                <i class="bi bi-phone-fill"></i>
                <span class="contact__info-text"><?php echo htmlspecialchars($contact['phone']); ?></span>
            </div>
            <?php endif; ?>

            <!-- ADDRESS -->
            <?php if($contact && !empty($contact['location'])): ?>
            <div class="contact__info-item">
                <i class="bi bi-geo-alt-fill"></i>
                <span class="contact__info-text"><?php echo htmlspecialchars($contact['location']); ?></span>
            </div>
            <?php endif; ?>

            <!-- AVAILABILITY with Schedule button -->
            <?php if(!empty($availability)): ?>
            <div class="contact__info-item contact__availability">
                <i class="bi bi-clock-fill"></i>
                <div class="availability__wrapper">
                    <span class="available-text">Available</span>
                    <button class="schedule-btn" type="button">View Schedule ▼</button>
                    
                    <!-- Schedule Dropdown -->
                    <div class="schedule-dropdown">
                        <?php foreach($days as $day): 
                            $dayData = $availability[$day] ?? [];
                        ?>
                        <div class="schedule-row">
                            <strong><?php echo $day; ?>:</strong>
                            <?php if(isset($dayData['holiday']) && $dayData['holiday'] === true): ?>
                                <span class="closed">Holiday / Closed</span>
                            <?php elseif(!empty($dayData['start']) && !empty($dayData['end'])): ?>
                                <span class="open">
                                    <?php 
                                    echo date("g:i A", strtotime($dayData['start'])) . ' - ' . date("g:i A", strtotime($dayData['end'])); 
                                    ?>
                                </span>
                            <?php else: ?>
                                <span class="not-set">Not set</span>
                            <?php endif; ?>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <!-- Social Links -->
            <div class="contact__social">
                <?php if($contact && !empty($contact['whatsapp'])): ?>
                    <?php 
                    $whatsappUrl = filter_var($contact['whatsapp'], FILTER_VALIDATE_URL) 
                        ? $contact['whatsapp'] 
                        : 'https://wa.me/' . htmlspecialchars($contact['whatsapp']);
                    ?>
                    <a href="<?php echo htmlspecialchars($whatsappUrl); ?>" target="_blank" rel="noopener noreferrer">
                        <i class="bi bi-whatsapp"></i>
                    </a>
                <?php endif; ?>

                <?php if($contact && !empty($contact['instagram'])): ?>
                    <?php 
                    $instagramUrl = filter_var($contact['instagram'], FILTER_VALIDATE_URL) 
                        ? $contact['instagram'] 
                        : 'https://instagram.com/' . htmlspecialchars($contact['instagram']);
                    ?>
                    <a href="<?php echo htmlspecialchars($instagramUrl); ?>" target="_blank" rel="noopener noreferrer">
                        <i class="bi bi-instagram"></i>
                    </a>
                <?php endif; ?>

                <?php if($contact && !empty($contact['telegram'])): ?>
                    <?php 
                    $telegramUrl = filter_var($contact['telegram'], FILTER_VALIDATE_URL) 
                        ? $contact['telegram'] 
                        : 'https://t.me/' . htmlspecialchars($contact['telegram']);
                    ?>
                    <a href="<?php echo htmlspecialchars($telegramUrl); ?>" target="_blank" rel="noopener noreferrer">
                        <i class="bi bi-telegram"></i>
                    </a>
                <?php endif; ?>
                
                <?php if($contact && !empty($contact['linkedin'])): ?>
                    <?php 
                    $linkedinUrl = filter_var($contact['linkedin'], FILTER_VALIDATE_URL) 
                        ? $contact['linkedin'] 
                        : 'https://linkedin.com/in/' . htmlspecialchars($contact['linkedin']);
                    ?>
                    <a href="<?php echo htmlspecialchars($linkedinUrl); ?>" target="_blank" rel="noopener noreferrer">
                        <i class="bi bi-linkedin"></i>
                    </a>
                <?php endif; ?>
                
                <?php if($contact && !empty($contact['github'])): ?>
                    <?php 
                    $githubUrl = filter_var($contact['github'], FILTER_VALIDATE_URL) 
                        ? $contact['github'] 
                        : 'https://github.com/' . htmlspecialchars($contact['github']);
                    ?>
                    <a href="<?php echo htmlspecialchars($githubUrl); ?>" target="_blank" rel="noopener noreferrer">
                        <i class="bi bi-github"></i>
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

