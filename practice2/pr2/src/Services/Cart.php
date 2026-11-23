<?php
declare(strict_types=1);

namespace Shop\Services;

use Shop\Models\Customer;
use Shop\Models\Product;

class Cart
{
    private array $items = [];

    public function __construct(public Customer $customer) {}

    public function add(Product $product, int $qty): void
    {
        if ($qty <= 0) {
            throw new \InvalidArgumentException('Количество должно быть больше нуля');
        }
        $this->items[] = ['product' => $product, 'qty' => $qty];
    }

    public function getTotal(): float
    {
        $total = 0;
        foreach ($this->items as $item) {
            $total += $item['product']->price * $item['qty'];
        }
        return $total;
    }
}
