<?php


require 'vendor/autoload.php';

use Ramsey\Uuid\Uuid;
use Reelz\Warehouse\Product;

$oldFilePath = __DIR__ . '/data/products.json';
$newFilePath = __DIR__ . '/data/products_updated.json';

if (!file_exists($oldFilePath)) {
    die("Old products.json file not found.\n");
}

$oldData = file_get_contents($oldFilePath);
$products = json_decode($oldData, true);

if (!is_array($products)) {
    die("Invalid JSON format.\n");
}

$newProducts = array_map(function ($product) {
    return [
        'id' => Uuid::uuid4()->toString(),
        'name' => $product['product_name'],
        'dateOfCreation' => $product['creation_date'],
        'lastUpdatedTime' => date('Y-m-d H:i:s'),
        'amountOfUnits' => $product['units_in_stock'],
        'qualityExpirationDate' =>
            $product['qualityExpirationDate'] ?? null,
        'price' => $product['price'] ?? 0.0
    ];
}, $products);


file_put_contents
($newFilePath,
    json_encode($newProducts,
        JSON_PRETTY_PRINT));

echo "Products have been updated and saved to $newFilePath\n";
