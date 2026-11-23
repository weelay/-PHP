<?php
declare(strict_types=1);

class QueryBuilder
{
    private string $table = '';
    private array $columns = ['*'];
    private array $conditions = [];
    private string $sort = '';
    private ?int $limitCount = null;

    public static function table(string $name): static
    {
        $builder = new static();
        $builder->table = $name;
        return $builder;
    }

    public function select(string ...$columns): static
    {
        $this->columns = $columns === [] ? ['*'] : $columns;
        return $this;
    }

    public function where(string $column, string $operator, string|int $value): static
    {
        $allowed = ['=', '!=', '>', '<', '>=', '<=', 'LIKE'];
        if (!in_array(strtoupper($operator), $allowed, true)) {
            throw new InvalidArgumentException('Неподдерживаемый оператор');
        }

        $this->conditions[] = "{$column} {$operator} " . $this->quote($value);
        return $this;
    }

    public function orderBy(string $column, string $direction = 'ASC'): static
    {
        $direction = strtoupper($direction);
        if (!in_array($direction, ['ASC', 'DESC'], true)) {
            throw new InvalidArgumentException('Сортировка должна быть ASC или DESC');
        }

        $this->sort = " ORDER BY {$column} {$direction}";
        return $this;
    }

    public function limit(int $count): static
    {
        if ($count <= 0) {
            throw new InvalidArgumentException('LIMIT должен быть больше нуля');
        }

        $this->limitCount = $count;
        return $this;
    }

    public function toSql(): string
    {
        $sql = 'SELECT ' . implode(', ', $this->columns) . ' FROM ' . $this->table;

        if ($this->conditions !== []) {
            $sql .= ' WHERE ' . implode(' AND ', $this->conditions);
        }

        $sql .= $this->sort;

        if ($this->limitCount !== null) {
            $sql .= ' LIMIT ' . $this->limitCount;
        }

        return $sql;
    }

    public function __toString(): string
    {
        return $this->toSql();
    }

    private function quote(string|int $value): string
    {
        if (is_int($value)) {
            return (string) $value;
        }
        return "'" . str_replace("'", "''", $value) . "'";
    }
}

echo "Запрос 1:" . PHP_EOL;
echo QueryBuilder::table('users')
    ->select('id', 'name', 'email')
    ->where('age', '>=', 18)
    ->where('city', '=', 'Москва')
    ->orderBy('name')
    ->limit(10) . PHP_EOL . PHP_EOL;

echo "Запрос 2:" . PHP_EOL;
echo QueryBuilder::table('products')
    ->select('name', 'price')
    ->where('price', '>', 1000)
    ->orderBy('price', 'DESC') . PHP_EOL . PHP_EOL;

echo "Запрос 3:" . PHP_EOL;
echo QueryBuilder::table('orders')
    ->where('status', '=', 'paid')
    ->limit(5)->toSql() . PHP_EOL . PHP_EOL;

echo "Проверка ошибок:" . PHP_EOL;
try {
    QueryBuilder::table('users')->orderBy('name', 'SIDEWAYS');
} catch (InvalidArgumentException $e) {
    echo $e->getMessage() . PHP_EOL;
}

try {
    QueryBuilder::table('users')->limit(0);
} catch (InvalidArgumentException $e) {
    echo $e->getMessage() . PHP_EOL;
}

try {
    QueryBuilder::table('users')->where('age', 'BETWEEN', 18);
} catch (InvalidArgumentException $e) {
    echo $e->getMessage() . PHP_EOL;
}
