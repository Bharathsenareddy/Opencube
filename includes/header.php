<?php
/** @var string $pageTitle */
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= e($pageTitle) ?> | Gem Opencube</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>
<header class="site-header glass">
  <div class="container row between center">
    <a href="/index.php" class="brand">
      <span class="brand-mark">◆</span>
      <span>GEM OPENCUBE</span>
    </a>
    <nav class="nav-links">
      <a href="/index.php">Home</a>
      <a href="/index.php#platforms">Technologies</a>
      <a href="/index.php#industries">Industries</a>
      <a href="/admin/index.php">Admin</a>
      <a class="btn btn-outline" href="/index.php#contact">Partner With Us</a>
    </nav>
  </div>
</header>
<main>
