<?php
require 'Shape.php';
require 'Circle.php';
require 'Rectangle.php';
require 'Triangle.php';

$shapes = [new Circle(5), new Rectangle(4, 6), new Triangle(3, 4, 5)];
foreach ($shapes as $shape) {
    echo $shape->describe() . "\n";
}
// Ошибка: нельзя создать объект абстрактного класса