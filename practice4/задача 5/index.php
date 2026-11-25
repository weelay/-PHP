<?php
spl_autoload_register(function(string $class): void {
    $prefix = 'App\\';
    $baseDir = __DIR__ . '/src/';
    if (str_starts_with($class, $prefix)) {
        $relative = substr($class, strlen($prefix));
        $file = $baseDir . str_replace('\\', '/', $relative) . '.php';
        if (file_exists($file)) require $file;
    }
});

use App\Book;
use App\Electronics;
use App\Product;

$catalog = [
    new Book('PHP для начинающих', 500),
    new Book('Чистый код', 800),
    new Electronics('Смартфон', 30000, 5),
    new Electronics('Ноутбук', 70000, 10),
    new Book('Алгоритмы', 1200),
    new Electronics('Наушники', 5000, 2)
];

$totalFinalPrice = 0;
foreach ($catalog as $item) {
    echo $item->getInfo() . "\n";
    $totalFinalPrice += $item->getFinalPrice();
}
echo "Сумма конечных цен: {$totalFinalPrice}\n";
echo "Всего товаров создано: " . Product::getCount() . "\n";