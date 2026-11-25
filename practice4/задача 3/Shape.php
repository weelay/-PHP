<?php
abstract class Shape {
    abstract public function area(): float;
    abstract public function perimeter(): float;
    abstract public function getName(): string;

    public function describe(): string {
        return sprintf("%s: площадь=%.2f, периметр=%.2f", $this->getName(), $this->area(), $this->perimeter());
    }
}