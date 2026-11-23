<?php
declare(strict_types=1);

class Employee
{
    public string $name;
    protected float $baseSalary;
    private string $passport;
    private array $salaryHistory = [];

    public function __construct(string $name, float $baseSalary, string $passport)
    {
        $this->name = $name;
        $this->baseSalary = $baseSalary;
        $this->passport = $passport;
    }

    public function getSalary(): float
    {
        return $this->baseSalary;
    }

    public function raiseSalary(float $percent): void
    {
        $this->validatePercent($percent);
        $oldSalary = $this->baseSalary;
        $this->baseSalary += $this->baseSalary * $percent / 100;
        $this->salaryHistory[] = [
            'old' => $oldSalary,
            'new' => $this->baseSalary,
            'percent' => $percent
        ];
    }

    final public function getMaskedPassport(): string
    {
        $digits = preg_replace('/\D/', '', $this->passport);
        return '**** **' . substr($digits, -4);
    }

    public function getSalaryHistory(): array
    {
        return $this->salaryHistory;
    }

    protected function calculateTax(float $amount): float
    {
        return $amount * 0.13;
    }

    private function validatePercent(float $percent): void
    {
        if ($percent < 1 || $percent > 50) {
            throw new InvalidArgumentException('Повышение должно быть от 1 до 50 процентов');
        }
    }

    public function getSalaryAfterTax(): float
    {
        return $this->getSalary() - $this->calculateTax($this->getSalary());
    }
}

class Manager extends Employee
{
    public function __construct(
        string $name,
        float $baseSalary,
        string $passport,
        private int $teamSize
    ) {
        parent::__construct($name, $baseSalary, $passport);
    }

    public function getSalary(): float
    {
        $salary = $this->baseSalary + 5000 * $this->teamSize;
        return $salary;
    }

    public function getSalaryAfterTax(): float
    {
        $salary = $this->getSalary();
        return $salary - $this->calculateTax($salary);
    }
}

class Developer extends Employee
{
    public function __construct(
        string $name,
        float $baseSalary,
        string $passport,
        private string $level
    ) {
        parent::__construct($name, $baseSalary, $passport);

        if (!in_array($level, ['junior', 'middle', 'senior'], true)) {
            throw new InvalidArgumentException('Уровень должен быть junior, middle или senior');
        }
    }

    public function getSalary(): float
    {
        $coefficients = [
            'junior' => 1.0,
            'middle' => 1.5,
            'senior' => 2.0
        ];

        return $this->baseSalary * $coefficients[$this->level];
    }

    public function getSalaryAfterTax(): float
    {
        $salary = $this->getSalary();
        return $salary - $this->calculateTax($salary);
    }

    // Если попробовать переопределить getMaskedPassport(), PHP выдаст ошибку:
    // Cannot override final method Employee::getMaskedPassport()
}

$employees = [
    new Employee('Иван', 50000, '1234 567890'),
    new Manager('Пётр', 70000, '2345 678901', 4),
    new Developer('Анна', 60000, '3456 789012', 'middle'),
    new Developer('Олег', 80000, '4567 890123', 'senior'),
];

$employees[0]->raiseSalary(10);

echo "Имя | Тип | Зарплата | После налога" . PHP_EOL;
foreach ($employees as $employee) {
    echo $employee->name . ' | '
        . get_class($employee) . ' | '
        . number_format($employee->getSalary(), 2, ',', ' ') . ' ₽ | '
        . number_format($employee->getSalaryAfterTax(), 2, ',', ' ') . ' ₽'
        . PHP_EOL;
}

echo PHP_EOL . "Паспорт сотрудника: " . $employees[0]->getMaskedPassport() . PHP_EOL;
echo "История изменения оклада:" . PHP_EOL;
print_r($employees[0]->getSalaryHistory());

// Проверки доступа. Эти строки намеренно закомментированы, чтобы программа запускалась.
// echo $employees[0]->baseSalary; // Ошибка: protected нельзя читать снаружи.
// echo $employees[0]->passport;   // Ошибка: private нельзя читать снаружи.

// Внутри Manager доступ к baseSalary есть, так как свойство protected.
// Доступа к passport у Manager нет, так как свойство private в Employee.
// calculateTax() снаружи вызвать нельзя, потому что метод protected.
// validatePercent() в Developer вызвать нельзя, потому что метод private в Employee.
