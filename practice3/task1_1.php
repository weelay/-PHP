<?php
declare(strict_types=1);

// Родительский класс
class Vehicle {
    protected string $brand;
    protected int $maxSpeed;

    public function __construct(string $brand, int $maxSpeed) {
        $this->brand = $brand;
        $this->maxSpeed = $maxSpeed;
    }

    public function getInfo(): string {
        return "Марка: {$this->brand}, макс. скорость: {$this->maxSpeed} км/ч";
    }
}

// Дочерний класс - автомобиль
class Car extends Vehicle {
    private string $fuelType;

    public function __construct(string $brand, int $maxSpeed, string $fuelType) {
        parent::__construct($brand, $maxSpeed);
        $this->fuelType = $fuelType;
    }

    public function getInfo(): string {
        return parent::getInfo() . ", топливо: {$this->fuelType}";
    }
}

// Дочерний класс - самолёт
class Airplane extends Vehicle {
    private int $wingspan;

    public function __construct(string $brand, int $maxSpeed, int $wingspan) {
        parent::__construct($brand, $maxSpeed);
        $this->wingspan = $wingspan;
    }

    public function getInfo(): string {
        return parent::getInfo() . ", размах крыльев: {$this->wingspan} м";
    }
}

$vehicles = [
    new Car('Toyota Camry', 210, 'бензин'),
    new Airplane('Boeing 737', 850, 35),
];

foreach ($vehicles as $v) {
    echo $v->getInfo() . PHP_EOL;
    echo 'Является Vehicle: ' . ($v instanceof Vehicle ? 'да' : 'нет') . PHP_EOL;
    echo '---' . PHP_EOL;
}