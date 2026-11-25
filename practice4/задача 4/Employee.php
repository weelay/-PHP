<?php
abstract class Employee {
    public const MIN_BONUS = 500;
    private static int $employeeCount = 0;

    public function __construct(protected string $name, protected float $salary) {
        self::$employeeCount++;
    }

    abstract public function calculateBonus(): float;

    public function getSalary(): float { return $this->salary; }

    public function getInfo(): string {
        return "{$this->name}, оклад: {$this->salary}, премия: {$this->calculateBonus()}";
    }

    public static function getEmployeeCount(): int {
        return self::$employeeCount;
    }
}