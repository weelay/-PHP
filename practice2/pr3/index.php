<?php
declare(strict_types=1);

class Student
{
    public const MIN_COURSE = 1;
    public const MAX_COURSE = 4;

    public ?string $email = null;
    public array $grades = [];
    public bool $isActive = true;

    public static int $totalStudents = 0;
    public static string $university = 'Колледж информационных технологий';

    public function __construct(
        public readonly int $id,
        public string $lastName,
        public string $firstName,
        public int $course
    ) {
        if ($course < self::MIN_COURSE || $course > self::MAX_COURSE) {
            throw new InvalidArgumentException('Курс должен быть от 1 до 4');
        }
        self::$totalStudents++;
    }

    public function getAverage(): float
    {
        if ($this->grades === []) {
            return 0;
        }
        return array_sum($this->grades) / count($this->grades);
    }
}

$students = [
    new Student(101, 'Иванов', 'Иван', 1),
    new Student(102, 'Петров', 'Пётр', 2),
    new Student(103, 'Сидорова', 'Анна', 3),
    new Student(104, 'Смирнов', 'Алексей', 4),
];

$students[0]->email = 'ivan@example.com';
$students[1]->email = 'petr@example.com';
$students[2]->email = null;
$students[3]->email = 'alex@example.com';

$students[0]->grades = [4, 5, 4];
$students[1]->grades = [5, 5, 4];
$students[2]->grades = [4, 4, 5];
$students[3]->grades = [3, 4, 5];

echo "Учебное заведение: " . Student::$university . PHP_EOL;
echo "Билет | ФИО | Курс | Почта | Средний балл" . PHP_EOL;

foreach ($students as $student) {
    $email = $student->email ?? 'не указана';
    $fio = $student->lastName . ' ' . $student->firstName;
    echo "{$student->id} | {$fio} | {$student->course} | {$email} | "
        . number_format($student->getAverage(), 2, ',', ' ') . PHP_EOL;
}

echo PHP_EOL . "Всего студентов: " . Student::$totalStudents . PHP_EOL;

// Эксперименты. Ошибочные строки оставлены в комментариях, чтобы файл запускался.
// $students[0]->id = 500; // Ошибка: readonly-свойство нельзя изменить после создания.
// $students[0]->course = 'третий'; // TypeError при strict_types=1.
// new Student(105, 'Ошибкин', 'Олег', 7); // InvalidArgumentException: курс должен быть от 1 до 4.

Student::$university = 'Новый колледж';
echo "Название после изменения: " . Student::$university . PHP_EOL;
echo "У всех объектов используется общее статическое значение." . PHP_EOL;

echo PHP_EOL . "var_dump одного объекта:" . PHP_EOL;
var_dump($students[0]);

echo PHP_EOL . "get_object_vars одного объекта:" . PHP_EOL;
print_r(get_object_vars($students[0]));
