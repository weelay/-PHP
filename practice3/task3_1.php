<?php
declare(strict_types=1);

trait LoggerTrait {
    protected array $logs = [];

    public function log(string $message): void {
        $this->logs[] = '[' . date('Y-m-d H:i:s') . "] {$message}";
    }

    public function getLogs(): array {
        return $this->logs;
    }

    public function clearLogs(): void {
        $this->logs = [];
    }
}

class UserService {
    use LoggerTrait;

    public function register(string $username): void {
        // регистрация пользователя...
        $this->log("Зарегистрирован пользователь: {$username}");
    }
}

class OrderService {
    use LoggerTrait;

    public function createOrder(int $orderId, float $total): void {
        // создание заказа...
        $this->log("Создан заказ #{$orderId} на сумму {$total} руб.");
    }
}

$users = new UserService();
$orders = new OrderService();

$users->register('alice');
$users->register('bob');
$orders->createOrder(1001, 4500.50);
$orders->createOrder(1002, 1200.00);

echo "=== Журнал UserService ===\n";
foreach ($users->getLogs() as $entry) echo $entry . PHP_EOL;

echo "\n=== Журнал OrderService ===\n";
foreach ($orders->getLogs() as $entry) echo $entry . PHP_EOL;

// Очищаем журнал заказов
$orders->clearLogs();
echo "\nПосле очистки OrderService:\n";
echo "UserService: " . count($users->getLogs()) . " записей\n";
echo "OrderService: " . count($orders->getLogs()) . " записей\n";

/*
Почему трейт удобнее наследования?

Трейт позволяет «вмешать» нужную функциональность в любые классы, не ломая их родословную. Плюс каждый объект получает СВОЮ копию $logs, поэтому журналы не пересекаются
*/