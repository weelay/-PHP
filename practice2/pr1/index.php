<?php
declare(strict_types=1);

require_once __DIR__ . '/Book.php';
require_once __DIR__ . '/Library.php';

$library = new Library();

$b1 = new Book('Мастер и Маргарита', 'М. Булгаков', 1967, 480);
$b2 = new Book('Собачье сердце', 'М. Булгаков', 1925, 384);
$b3 = new Book('Преступление и наказание', 'Ф. Достоевский', 1866, 672);
$b4 = new Book('Война и мир', 'Л. Толстой', 1869, 1300);
$b5 = new Book('Отцы и дети', 'И. Тургенев', 1862, 288);

foreach ([$b1, $b2, $b3, $b4, $b5] as $book) {
    $library->addBook($book);
}

echo "Все книги библиотеки:" . PHP_EOL;
$library->printAll();

echo PHP_EOL . "Книги М. Булгакова:" . PHP_EOL;
foreach ($library->findByAuthor('М. Булгаков') as $book) {
    echo $book->getInfo() . PHP_EOL;
}

echo PHP_EOL . "Количество книг: " . $library->count() . PHP_EOL;
echo "Возраст первой книги: " . $b1->getAge() . " лет" . PHP_EOL;

echo "Самая старая книга: " . $library->getOldest()?->getInfo() . PHP_EOL;

// Присваивание передаёт ссылку на тот же объект, а clone создаёт отдельный объект.
$b2copy = $b1;
$b3copy = clone $b1;
$b1->title = 'Новое название';

echo PHP_EOL . "Проверка копирования:" . PHP_EOL;
echo '$b1: ' . $b1->getInfo() . PHP_EOL;
echo '$b2: ' . $b2copy->getInfo() . PHP_EOL;
echo '$b3: ' . $b3copy->getInfo() . PHP_EOL;
