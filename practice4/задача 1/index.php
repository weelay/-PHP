<?php
spl_autoload_register(function(string $class): void {
    $path = __DIR__ . '/classes/' . $class . '.php';
    if (file_exists($path)) {
        require $path;
    }
});

$user = new User('Иван', 'ivan@example.com');
$p1 = new Product('Телефон', 15000);
$p2 = new Product('Чехол', 1000);
$order = new Order($user, [$p1, $p2]);

echo $order->getUserInfo() . "\n";
echo 'Сумма заказа: ' . $order->getTotal() . " руб.\n";