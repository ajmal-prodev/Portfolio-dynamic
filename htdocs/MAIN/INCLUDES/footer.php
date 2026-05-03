<?php
include('dbConnection.php');

// Fetch footer data from database
$query = "SELECT * FROM footer WHERE id = 1";
$result = $conn->query($query);
$footer = null;

if ($result && $result->num_rows > 0) {
    $footer = $result->fetch_assoc();
}
?>

<!--==================== FOOTER ====================-->
<footer class="footer">
    <div class="footer__container container grid">
        <a href="#" class="footer__logo">
            <?php echo $footer && !empty($footer['logo_text']) ? htmlspecialchars($footer['logo_text']) : 'Ajmal'; ?>
        </a>

        <div class="footer__links">
            <a href="#home" class="footer__link">Home</a>
            <a href="#about" class="footer__link">About</a>
            <a href="#projects" class="footer__link">Projects</a>
        </div>

        <div class="footer__social">
            <?php if($footer && !empty($footer['facebook'])): ?>
                <a href="<?php echo htmlspecialchars($footer['facebook']); ?>" target="_blank" class="footer__social-link">
                    <i class="bi bi-facebook"></i>
                </a>
            <?php else: ?>
                <a href="#" target="_blank" class="footer__social-link">
                    <i class="bi bi-facebook"></i>
                </a>
            <?php endif; ?>

            <?php if($footer && !empty($footer['instagram'])): ?>
                <a href="<?php echo htmlspecialchars($footer['instagram']); ?>" target="_blank" class="footer__social-link">
                    <i class="bi bi-instagram"></i>
                </a>
            <?php else: ?>
                <a href="#" target="_blank" class="footer__social-link">
                    <i class="bi bi-instagram"></i>
                </a>
            <?php endif; ?>

            <?php if($footer && !empty($footer['twitter_x'])): ?>
                <a href="<?php echo htmlspecialchars($footer['twitter_x']); ?>" target="_blank" class="footer__social-link">
                    <i class="bi bi-twitter-x"></i>
                </a>
            <?php else: ?>
                <a href="#" target="_blank" class="footer__social-link">
                    <i class="bi bi-twitter-x"></i>
                </a>
            <?php endif; ?>

            <?php if($footer && !empty($footer['youtube'])): ?>
                <a href="<?php echo htmlspecialchars($footer['youtube']); ?>" target="_blank" class="footer__social-link">
                    <i class="bi bi-youtube"></i>
                </a>
            <?php else: ?>
                <a href="#" target="_blank" class="footer__social-link">
                    <i class="bi bi-youtube"></i>
                </a>
            <?php endif; ?>
             <a href="Admin/login.php" target="_blank" class="footer__social-link">
                    <i class="bi bi-person-circle"></i>
             </a>
        </div>
    </div>

    <span class="footer__copy">
        <?php echo $footer && !empty($footer['copyright_text']) 
            ? htmlspecialchars($footer['copyright_text']) 
            : '&#169; All Rights Reserved By Ajmal'; ?>
    </span>
</footer>

<!--========== SCROLL UP ==========-->
<a href="#" class="scrollup" id="scroll-up">
    <i class="bi bi-arrow-up"></i>
</a>

<!--=============== SCROLLREVEAL ===============-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/scrollReveal.js/4.0.9/scrollreveal.min.js"></script>
<script src="ASSETS/CDN/scrollreveal.js"></script>
<!--=============== TYPED JS ===============-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/typed.js/2.1.0/typed.umd.min.js"></script>
<script src="ASSETS/CDN/typed.umd.min.js"></script>
<!--=============== EMAIL JS ===============-->
<script src="https://cdn.jsdelivr.net/npm/@emailjs/browser@4/dist/email.min.js"></script>
<script src="ASSETS/CDN/email.min.js"></script>
<!--=============== MAIN JS ===============-->
<script src="ASSETS/JS/mainpage.js"></script>
