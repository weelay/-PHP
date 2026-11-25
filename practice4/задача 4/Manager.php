<?php
require_once 'Employee.php';
class Manager extends Employee {
    public function calculateBonus(): float {
        return max($this->salary * 0.20, self::MIN_BONUS);
    }
}