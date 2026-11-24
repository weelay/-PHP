<?php
declare(strict_types=1);

interface ReportFormatterInterface {
    public function format(array $data): string;
}

interface ReportHeaderInterface {
    public const SEPARATOR = '================================';
    public function getHeader(): string;
}

class HtmlFormatter implements ReportFormatterInterface {
    public function format(array $data): string {
        $items = '';
        foreach ($data as $item) {
            $items .= "<li>{$item}</li>";
        }
        return "<ul>{$items}</ul>";
    }
}

class CsvFormatter implements ReportFormatterInterface {
    public function format(array $data): string {
        return implode(';', $data);
    }
}

class SalesReport implements ReportFormatterInterface, ReportHeaderInterface {
    private array $sales;

    public function __construct(array $sales) {
        $this->sales = $sales;
    }

    public function getHeader(): string {
        return 'Отчёт о продажах за текущий период';
    }

    public function format(array $data): string {
        $lines = [];
        foreach ($data as $product => $sum) {
            $lines[] = "Продукт: {$product} — сумма: {$sum} руб.";
        }
        return implode(PHP_EOL, $lines);
    }

    public function getSales(): array {
        return $this->sales;
    }
}

function renderReport(ReportFormatterInterface $report): void {
    if ($report instanceof ReportHeaderInterface) {
        echo $report->getHeader() . PHP_EOL;
        echo ReportHeaderInterface::SEPARATOR . PHP_EOL;
    }
    echo $report->format($report->getSales()) . PHP_EOL;
}

$sales = ['Ноутбук' => 75000, 'Мышь' => 1200, 'Клавиатура' => 3500];
$report = new SalesReport($sales);

renderReport($report);

echo PHP_EOL . 'Константа SEPARATOR: ' . ReportHeaderInterface::SEPARATOR . PHP_EOL;