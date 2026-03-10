<?php

declare(strict_types=1);

const DATA_FILE = __DIR__ . '/../data/products.json';

function loadProducts(): array
{
    if (!file_exists(DATA_FILE)) {
        return [];
    }

    $json = file_get_contents(DATA_FILE);
    if ($json === false) {
        return [];
    }

    $products = json_decode($json, true);

    return is_array($products) ? $products : [];
}

function saveProducts(array $products): bool
{
    $json = json_encode($products, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);

    return $json !== false && file_put_contents(DATA_FILE, $json . PHP_EOL, LOCK_EX) !== false;
}

function findProductBySlug(string $slug): ?array
{
    foreach (loadProducts() as $product) {
        if (($product['slug'] ?? '') === $slug) {
            return $product;
        }
    }

    return null;
}

function e(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}
