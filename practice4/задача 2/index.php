<?php
spl_autoload_register(function(string $class): void {
    $prefix = 'App\\';
    $baseDir = __DIR__ . '/src/';
    if (str_starts_with($class, $prefix)) {
        $relative = substr($class, strlen($prefix));
        $file = $baseDir . str_replace('\\', '/', $relative) . '.php';
        if (file_exists($file)) {
            require $file;
        }
    }
});

use App\Models\Product;
use App\Services\PriceFormatter;

$product = new Product('Ноутбук', 55000.50);
echo $product->getTitle() . ': ' . PriceFormatter::format($product->getPrice()) . "\n";