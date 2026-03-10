<?php

declare(strict_types=1);
require_once __DIR__ . '/../includes/functions.php';

$products = loadProducts();
$message = null;
$error = null;
$editingSlug = isset($_GET['edit']) ? trim((string) $_GET['edit']) : '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = (string) ($_POST['action'] ?? '');

    if ($action === 'delete') {
        $slug = trim((string) ($_POST['slug'] ?? ''));
        $products = array_values(array_filter($products, static fn(array $item): bool => ($item['slug'] ?? '') !== $slug));

        if (saveProducts($products)) {
            header('Location: /admin/index.php?status=deleted');
            exit;
        }
        $error = 'Unable to delete the product.';
    }

    if ($action === 'save') {
        $originalSlug = trim((string) ($_POST['original_slug'] ?? ''));
        $name = trim((string) ($_POST['name'] ?? ''));
        $slug = trim((string) ($_POST['slug'] ?? ''));
        $category = trim((string) ($_POST['category'] ?? ''));
        $tagline = trim((string) ($_POST['tagline'] ?? ''));
        $shortDescription = trim((string) ($_POST['short_description'] ?? ''));
        $description = trim((string) ($_POST['description'] ?? ''));
        $image = trim((string) ($_POST['image'] ?? ''));
        $featuresRaw = trim((string) ($_POST['features'] ?? ''));
        $features = array_values(array_filter(array_map('trim', explode(PHP_EOL, $featuresRaw))));

        if ($name === '' || $slug === '') {
            $error = 'Name and slug are required fields.';
        } else {
            $updated = false;
            foreach ($products as &$item) {
                if (($item['slug'] ?? '') === $originalSlug) {
                    $item = [
                        'slug' => $slug,
                        'name' => $name,
                        'tagline' => $tagline,
                        'category' => $category,
                        'short_description' => $shortDescription,
                        'description' => $description,
                        'features' => $features,
                        'image' => $image,
                    ];
                    $updated = true;
                    break;
                }
            }
            unset($item);

            if (!$updated) {
                $products[] = [
                    'slug' => $slug,
                    'name' => $name,
                    'tagline' => $tagline,
                    'category' => $category,
                    'short_description' => $shortDescription,
                    'description' => $description,
                    'features' => $features,
                    'image' => $image,
                ];
            }

            if (saveProducts($products)) {
                header('Location: /admin/index.php?status=saved');
                exit;
            }

            $error = 'Unable to save product data.';
        }
    }
}

$status = (string) ($_GET['status'] ?? '');
if ($status === 'saved') {
    $message = 'Product saved successfully.';
}
if ($status === 'deleted') {
    $message = 'Product deleted successfully.';
}

$products = loadProducts();
$editingProduct = null;
if ($editingSlug !== '') {
    $editingProduct = findProductBySlug($editingSlug);
}

$pageTitle = 'Admin Dashboard';
require_once __DIR__ . '/../includes/header.php';
?>
<section class="admin-shell">
  <div class="container">
    <h1>Admin Dashboard</h1>
    <p>Manage products visible on the website and individual product pages.</p>

    <?php if ($message !== null): ?>
      <div class="alert alert-success"><?= e($message) ?></div>
    <?php endif; ?>
    <?php if ($error !== null): ?>
      <div class="alert alert-error"><?= e($error) ?></div>
    <?php endif; ?>

    <div class="panel">
      <h2><?= $editingProduct ? 'Edit Product' : 'Add Product' ?></h2>
      <form method="post" action="/admin/index.php">
        <input type="hidden" name="action" value="save">
        <input type="hidden" name="original_slug" value="<?= e($editingProduct['slug'] ?? '') ?>">

        <label for="name">Name</label>
        <input id="name" name="name" required value="<?= e($editingProduct['name'] ?? '') ?>">

        <label for="slug">Slug</label>
        <input id="slug" name="slug" required value="<?= e($editingProduct['slug'] ?? '') ?>">

        <label for="category">Category</label>
        <input id="category" name="category" value="<?= e($editingProduct['category'] ?? '') ?>">

        <label for="tagline">Tagline</label>
        <input id="tagline" name="tagline" value="<?= e($editingProduct['tagline'] ?? '') ?>">

        <label for="short_description">Short Description</label>
        <textarea id="short_description" name="short_description" rows="2"><?= e($editingProduct['short_description'] ?? '') ?></textarea>

        <label for="description">Description</label>
        <textarea id="description" name="description" rows="4"><?= e($editingProduct['description'] ?? '') ?></textarea>

        <label for="features">Features (one per line)</label>
        <textarea id="features" name="features" rows="4"><?php
          echo e(isset($editingProduct['features']) && is_array($editingProduct['features']) ? implode(PHP_EOL, $editingProduct['features']) : '');
        ?></textarea>

        <label for="image">Image URL</label>
        <input id="image" name="image" value="<?= e($editingProduct['image'] ?? '') ?>">

        <button type="submit" class="btn btn-primary">Save Product</button>
        <a href="/admin/index.php" class="btn btn-soft">Clear</a>
      </form>
    </div>

    <div class="panel">
      <h2>Current Products</h2>
      <table class="table">
        <thead><tr><th>Name</th><th>Category</th><th>Actions</th></tr></thead>
        <tbody>
        <?php foreach ($products as $product): ?>
          <tr>
            <td><?= e($product['name']) ?></td>
            <td><?= e($product['category']) ?></td>
            <td>
              <a class="btn btn-outline" href="/admin/index.php?edit=<?= e($product['slug']) ?>">Edit</a>
              <form method="post" action="/admin/index.php" style="display:inline-block" onsubmit="return confirm('Delete this product?');">
                <input type="hidden" name="action" value="delete">
                <input type="hidden" name="slug" value="<?= e($product['slug']) ?>">
                <button type="submit" class="btn btn-soft">Delete</button>
              </form>
            </td>
          </tr>
        <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</section>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
