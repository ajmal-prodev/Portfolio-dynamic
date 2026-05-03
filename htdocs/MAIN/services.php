<?php
include('dbConnection.php');
?>

<!--==================== SERVICES ====================-->
<section class="services section" id="services">
    <?php
    // Fetch all services from database
    $query = "SELECT * FROM services ORDER BY id DESC";
    $result = $conn->query($query);
    
    $services = [];
    if ($result && $result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $services[] = [
                'id' => $row['id'],
                'designation' => $row['designation'],
                'description' => $row['description'],
                'icon_class' => $row['icon_class'],
                'link' => $row['link']
            ];
        }
    }
    ?>
    
    <h3 class="section__title">Services</h3>
    
    <?php if(!empty($services)): ?>
        <div class="services__container container grid">
            <?php foreach($services as $index => $service): 
                $animationClass = ($index % 2 == 0) ? 'animate__animated animate__fadeInDown' : 'animate__animated animate__fadeInUp';
            ?>
                <article class="services__card <?php echo $animationClass; ?>">
                    <i class="<?php echo htmlspecialchars($service['icon_class']); ?> services__icons"></i>
                    <h3 class="services__firsticon"><?php echo htmlspecialchars($service['designation']); ?></h3>
                    <div class="services__data">
                        <h3 class="services__title"><?php echo htmlspecialchars($service['designation']); ?></h3>
                        <p class="services__description"><?php echo htmlspecialchars($service['description']); ?></p>
                        <?php if(!empty($service['link'])): ?>
                            <a href="<?php echo htmlspecialchars($service['link']); ?>" target="" class="button button__ghost">Get Started</a>
                        <?php else: ?>
                            <a href="#contact" target="" class="button button__ghost">Get Started</a>
                        <?php endif; ?>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="services__container container">
            <div class="text-center py-5">
                <p class="text-muted">No services added yet. Please add services through the admin panel.</p>
            </div>
        </div>
    <?php endif; ?>
</section>