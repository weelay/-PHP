<?php
declare(strict_types=1);

trait JsonExportTrait {
    public function export(): string {
        $data = [];
        foreach (get_object_vars($this) as $k => $v) {
            $data[$k] = $v;
        }
        return json_encode($data, JSON_UNESCAPED_UNICODE);
    }

    public function getFormat(): string {
        return 'JSON';
    }
}

trait XmlExportTrait {
    public function export(): string {
        $xml = '<product>';
        foreach (get_object_vars($this) as $k => $v) {
            $xml .= "<{$k}>{$v}</{$k}>";
        }
        return $xml . '</product>';
    }

    public function getFormat(): string {
        return 'XML';
    }
}

trait PriceTrait {
    public function getPriceWithTax(float $tax): float {
        return $this->price * (1 + $tax / 100);
    }
}

class Product {
    use JsonExportTrait, XmlExportTrait, PriceTrait {
        // Разрешаем конфликт export(): основной - из JSON
        JsonExportTrait::export insteadof XmlExportTrait;
        // XML-версию сохраняем под псевдонимом
        XmlExportTrait::export as exportToXml;

        // Разрешаем конфликт getFormat(): основной - из JSON
        JsonExportTrait::getFormat insteadof XmlExportTrait;
        // XML-вариант — под псевдонимом
        XmlExportTrait::getFormat as getXmlFormat;
    }

    public string $name;
    public float $price;

    public function __construct(string $name, float $price) {
        $this->name = $name;
        $this->price = $price;
    }

    // Метод САМОГО класса - имеет наивысший приоритет
    public function getFormat(): string {
        return 'Product format';
    }
}

$p = new Product('Смартфон', 25000);

echo "JSON: " . $p->export() . PHP_EOL;
echo "XML:  " . $p->exportToXml() . PHP_EOL;
echo "Формат (основной): " . $p->getFormat() . PHP_EOL;
echo "Формат XML:        " . $p->getXmlFormat() . PHP_EOL;
echo "Цена с налогом 20%: " . $p->getPriceWithTax(20) . " руб.\n";

/*
Приоритет методов в PHP:
1) Метод, объявленный в самом классе (высший приоритет)
2) Метод из трейта
3) Метод, унаследованный от родителя
*/