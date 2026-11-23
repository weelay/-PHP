<?php
declare(strict_types=1);

class Book
{
    public function __construct(
        public string $title,
        public string $author,
        public int $year,
        public int $pages
    ) {}

    public function getInfo(): string
    {
        return "{$this->title} — {$this->author}, {$this->year}, {$this->pages} стр.";
    }

    public function getAge(): int
    {
        return (int) date('Y') - $this->year;
    }
}
