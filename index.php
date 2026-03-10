<?php

declare(strict_types=1);
require_once __DIR__ . '/includes/functions.php';

$products = loadProducts();
$pageTitle = 'Automation Infrastructure';
require_once __DIR__ . '/includes/header.php';
?>
<section class="hero">
  <div class="container hero-grid">
    <div>
      <h1>Automation Infrastructure for the Next Generation</h1>
      <p>Gem Opencube builds intelligent platforms for automated retail, AI infrastructure, smart public systems, and advanced technology solutions.</p>
      <div class="row gap-md wrap">
        <a href="#platforms" class="btn btn-primary">Explore Platforms</a>
        <a href="#contact" class="btn btn-outline">Partner With Us</a>
      </div>
    </div>
    <div class="hero-media">
      <img src="https://images.unsplash.com/photo-1603791440384-56cd371ee9a7?auto=format&fit=crop&w=1200&q=80" alt="Futuristic automation systems">
    </div>
  </div>
</section>

<section id="platforms" class="section">
  <div class="container">
    <h2>Technology Platforms</h2>
    <div class="cards">
      <?php foreach ($products as $product): ?>
      <article class="card">
        <img src="<?= e($product['image']) ?>" alt="<?= e($product['name']) ?>">
        <div class="card-body">
          <h3><?= e($product['name']) ?></h3>
          <p><?= e($product['tagline']) ?></p>
          <p><?= e($product['short_description']) ?></p>
          <a class="learn" href="/product.php?slug=<?= e($product['slug']) ?>">Learn More →</a>
        </div>
      </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section id="industries" class="section">
  <div class="container industries-grid">
    <div>
      <h2>Industries</h2>
      <p>Gem Opencube is at the forefront of innovation in automated public systems, retail platforms, and AI technologies, creating solutions that transform industries and create smarter operations.</p>
      <div class="row gap-md wrap">
        <a href="#contact" class="btn btn-primary">Become a Partner</a>
        <a href="#contact" class="btn btn-outline">Request Information</a>
      </div>
    </div>
    <div class="industry-media">
      <img src="https://images.unsplash.com/photo-1593508512255-86ab42a8e620?auto=format&fit=crop&w=1200&q=80" alt="Industry deployment of automated kiosks">
    </div>
  </div>
</section>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
