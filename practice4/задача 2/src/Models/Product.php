<?php
namespace App\Models;
class Product {
    public function __construct(private string $title, private float $price) {}
    public function getTitle(): string { return $this->title; }
    public function getPrice(): float { return $this->price; }
}