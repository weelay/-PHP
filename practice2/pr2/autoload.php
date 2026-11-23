<?php
declare(strict_types=1);

spl_autoload_register(function (string $class): void {
    $prefix = 'Shop\\';
    $baseDir = __DIR__ . '/src/';

    if (!str_starts_with($class, $prefix)) {
        return;
    }

    $relativeClass = substr($class, strlen($prefix));
    $file = $baseDir . str_replace('\\', '/', $relativeClass) . '.php';

    if (is_file($file)) {
        echo "Загружен класс: {$class}" . PHP_EOL;
        require $file;
    }
});
