<?php
// Database connection
include('dbConnection.php');
// $conn = new mysqli("localhost", "root", "", "portfolio_db");

// Fetch active theme values
$theme_query = $conn->query("SELECT hue_value, first_color_saturation, first_color_lightness FROM themes WHERE is_active = 1 LIMIT 1");
$active_theme = $theme_query->fetch_assoc();

// Set default values if no theme exists
$current_hue = $active_theme['hue_value'] ?? 180;
$firstpercentage = $active_theme['first_color_saturation'] ?? 80;
$secondpercentage = $active_theme['first_color_lightness'] ?? 48;
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="shortcut icon" href="ASSETS/IMAGES/logotitle.jpg">


   <!-- CDN -->
   <link rel="stylesheet" href="ASSETS/CDN/remixicon.css">
   <!-- <link rel="stylesheet" href="ASSETS/CDN/bootstrap.min.css"> -->
   <link rel="stylesheet" href="ASSETS/CDN/bootstrap-icons-1.13.1/bootstrap-icons.css">
   <link rel="stylesheet" href="ASSETS/CDN/animate.css">

   <!-- CSS -->
   <link rel="stylesheet" href="ASSETS/CSS/globalportfolios.css">
   <link rel="stylesheet" href="ASSETS/CSS/header.css">
   <link rel="stylesheet" href="ASSETS/CSS/homeportfolio.css">
   <link rel="stylesheet" href="ASSETS/CSS/aboutportfolio.css">
   <link rel="stylesheet" href="ASSETS/CSS/projectsportfolio.css">
   <link rel="stylesheet" href="ASSETS/CSS/resume.css">
   <link rel="stylesheet" href="ASSETS/CSS/servicesajmal.css">
   <link rel="stylesheet" href="ASSETS/CSS/newcontact.css">
   <link rel="stylesheet" href="ASSETS/CSS/footerportfolio.css">
   <link rel="stylesheet" href="ASSETS/CSS/scrollupandscrollbarportfolio.css">
   <style>
    :root {
  --header-height: 3.5rem;

  /*========== Dynamic Colors ==========*/
  /* The hue is pulled directly from your MySQL table */
  --hue: <?php echo $current_hue; ?>;
  
  /* All other colors automatically update because they reference --hue */
  --first-color: hsl(var(--hue), <?php echo $firstpercentage; ?>%, <?php echo $secondpercentage; ?>%);
  --first-color-alt: hsl(var(--hue), 80%, 44%);
  --white-color: hsl(var(--hue), 8%, 92%);
  --black-color: hsl(var(--hue), 4%, 8%);
  --gray-color: hsl(var(--hue), 4%, 50%);
  --body-color: hsl(var(--hue), 8%, 8%);
  --container-color: hsl(var(--hue), 8%, 12%);

  /*========== Font and typography ==========*/
  --body-font: "Unbounded", sans-serif;
  --bigger-font-size: 2rem;
  --h1-font-size: 1.5rem;
  --h2-font-size: 1.25rem;
  --h3-font-size: 1rem;
  --normal-font-size: .938rem;
  --small-font-size: .813rem;

  /*========== Font weight ==========*/
  --font-light: 300;
  --font-regular: 400;
  --font-medium: 500;
  --font-semi-bold: 600;

  /*========== z index ==========*/
  --z-tooltip: 10;
  --z-fixed: 100;
}

</style>

   <title>Ajmal Portfolio</title>
</head>

<body>

<header class="header" id="header">
   <nav class="nav container">
      <a href="#" class="nav__logo">Ajmal</a>

      <div class="nav__menu" id="nav-menu">
         <ul class="nav__list">
            <li><a href="#home" class="nav__link active-link">Home</a></li>
            <li><a href="#about" class="nav__link">About</a></li>
            <li><a href="#projects" class="nav__link">Projects</a></li>
            <li><a href="#resume" class="nav__link">Resume</a></li>
            <li><a href="#services" class="nav__link">Services</a></li>
            <li><a href="#contact" class="nav__link">Contact</a></li>
         </ul>

         <div class="nav__close" id="nav-close">
            <i class="bi bi-x-square"></i>
         </div>
      </div>

      <div class="nav__toggle" id="nav-toggle">
         <i class="bi bi-list"></i>
      </div>
   </nav>
</header>