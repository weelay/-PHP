<?php
declare(strict_types=1);

abstract class Employee {
    protected string $name;
    protected float $baseSalary;

    public function __construct(string $name, float $baseSalary) {
        $this->name = $name;
        $this->baseSalary = $baseSalary;
    }

    abstract public function calculateSalary(): float;

    public function getName(): string {
        return $this->name;
    }
}

class Manager extends Employee {
    public function calculateSalary(): float {
        return $this->baseSalary * 1.20; // +20% премия
    }
}

class Developer extends Employee {
    private int $overtimeHours = 0;

    public function setOvertimeHours(int $hours): void {
        $this->overtimeHours = $hours;
    }

    public function calculateSalary(): float {
        return $this->baseSalary + $this->overtimeHours * 500;
    }
}

class Intern extends Employee {
    public function calculateSalary(): float {
        return $this->baseSalary * 0.50; // 50% от оклада
    }
}

function printPayroll(array $employees): void {
    echo str_pad('Имя', 20) . 'Зарплата' . PHP_EOL;
    echo str_repeat('-', 35) . PHP_EOL;

    $total = 0.0;
    foreach ($employees as $emp) {
        $salary = $emp->calculateSalary();
        echo str_pad($emp->getName(), 20) . number_format($salary, 2, '.', ' ') . " руб.\n";
        $total += $salary;
    }

    echo str_repeat('-', 35) . PHP_EOL;
    echo 'Итого ФОТ: ' . number_format($total, 2, '.', ' ') . " руб.\n";
}

$dev = new Developer('Иван Петров', 80000);
$dev->setOvertimeHours(10);

$employees = [
    new Manager('Анна Сидорова', 100000),
    $dev,
    new Intern('Ольга Новикова', 40000),
];

printPayroll($employees);

/*
Почему нельзя создать объект Employee напрямую?

Класс объявлен как abstract — это значит, что он является лишь шаблоном для дочерних классов. PHP физически не позволит сделать new Employee(),
потому что такой объект был бы «неполноценным» - без реализации ключевого метода. Абстрактный класс существует только для наследования
 */