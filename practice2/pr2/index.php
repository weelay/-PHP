<?php
declare(strict_types=1);

require __DIR__ . '/autoload.php';


use Shop\Models\Product;
use Shop\Models\Customer;
use Shop\Services\Cart;
use Shop\Helpers\PriceFormatter;

$customer = new Customer('Иван Петров', 'ivan@example.com');
$cart = new Cart($customer);

$cart->add(new Product('Клавиатура', 2500), 1);
$cart->add(new Product('Мышь', 1250), 2);
$cart->add(new Product('Монитор', 15000), 1);

echo "Покупатель: {$customer->name}" . PHP_EOL;
echo "Итого: " . PriceFormatter::format($cart->getTotal()) . PHP_EOL;

$order = new \Shop\Models\Order();
