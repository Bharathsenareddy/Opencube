<?php

declare(strict_types=1);
require_once __DIR__ . '/includes/functions.php';

$slug = isset($_GET['slug']) ? trim((string) $_GET['slug']) : '';
$product = findProductBySlug($slug);

if ($product === null) {
    http_response_code(404);
    $pageTitle = 'Product Not Found';
    require_once __DIR__ . '/includes/header.php';
    echo '<section class="section"><div class="container"><h1>Product not found</h1><p>The requested product page does not exist.</p><a href="/index.php" class="btn btn-primary">Back to Home</a></div></section>';
    require_once __DIR__ . '/includes/footer.php';
    exit;
}

$pageTitle = $product['name'];
require_once __DIR__ . '/includes/header.php';
?>
<section class="product-hero">
  <div class="container hero-grid">
    <div>
      <p class="meta"><?= e($product['category']) ?></p>
      <h1><?= e($product['name']) ?></h1>
      <p><?= e($product['description']) ?></p>
      <a class="btn btn-primary" href="/index.php#platforms">Explore More Platforms</a>
    </div>
    <div>
      <img src="<?= e($product['image']) ?>" alt="<?= e($product['name']) ?>">
    </div>
  </div>
</section>
<section class="section">
  <div class="container panel">
    <h2>Key Features</h2>
    <ul class="feature-list">
      <?php foreach ($product['features'] as $feature): ?>
        <li><?= e((string) $feature) ?></li>
      <?php endforeach; ?>
    </ul>
  </div>
</section>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
