<?php
class User {
    public function __construct(private string $name, private string $email) {}
    public function getInfo(): string {
        return "{$this->name} ({$this->email})";
    }
}