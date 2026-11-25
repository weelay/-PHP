<?php
require_once 'Employee.php';
class Developer extends Employee {
    public function __construct(protected string $name, protected float $salary, private int $experienceYears) {
        parent::__construct($name, $salary);
    }
    public function calculateBonus(): float {
        return max($this->salary * 0.15 + 1000 * $this->experienceYears, self::MIN_BONUS);
    }
}