<?php
class Product {
    public function __construct(private string $title, private float $price) {}
    public function getPrice(): float { return $this->price; }
}