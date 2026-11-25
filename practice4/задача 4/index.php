<?php
require 'Employee.php';
require 'Manager.php';
require 'Developer.php';

$employees = [
    new Manager('Анна', 60000),
    new Developer('Олег', 80000, 3),
    new Manager('Игорь', 40000),
    new Developer('Мария', 50000, 1)
];

$totalPayout = 0;
foreach ($employees as $emp) {
    echo $emp->getInfo() . "\n";
    $totalPayout += $emp->getSalary() + $emp->calculateBonus();
}
echo "Общая сумма выплат: {$totalPayout}\n";
echo "Количество сотрудников: " . Employee::getEmployeeCount() . "\n";