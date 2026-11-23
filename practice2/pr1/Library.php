<?php
declare(strict_types=1);

require_once __DIR__ . '/Book.php';

class Library
{
    private array $books = [];

    public function addBook(Book $book): void
    {
        $this->books[] = $book;
    }

    public function findByAuthor(string $author): array
    {
        return array_filter(
            $this->books,
            fn(Book $book) => $book->author === $author
        );
    }

    public function count(): int
    {
        return count($this->books);
    }

    public function printAll(): void
    {
        foreach ($this->books as $book) {
            echo $book->getInfo() . PHP_EOL;
        }
    }

    public function getOldest(): ?Book
    {
        if ($this->books === []) {
            return null;
        }

        $oldest = $this->books[0];
        foreach ($this->books as $book) {
            if ($book->year < $oldest->year) {
                $oldest = $book;
            }
        }
        return $oldest;
    }
}
