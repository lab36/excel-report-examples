<?php


namespace App\ExcelReport;


use Lab36\ExcelReport\ExcelReport;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class OrdersReport extends ExcelReport
{
    public function columnMappings(): array
    {
        return [
            'order_no' => 'Order no.',
            'order_details' => 'Order details',
            'sku' => 'SKU',
            'order_type' => 'Order type',
            'order_date' => 'Order date',
            'quantity' => 'quantity',
            'price' => 'Price',
        ];
    }


    public function columnFormats(): array
    {
        return [
            'sku' => 'TEXT',
            'order_date' => 'DATE_YYYY-MM-DD',
            'delivery_date' => 'DATE_YYYY-MM-DD',
            'price' => 'FORMAT_CURRENCY_EUR_SIMPLE',
        ];
    }


    public function columnWidth(): array
    {
        return [
            'order_details' => '30',
        ];
    }


    public function overrideCell(Worksheet $active_sheet, int $current_row_no, int $column_no, string $value, array $row_data, string $column_name)
    {
        if ($column_name == 'order_type' && is_numeric($value)) {
            $active_sheet->setCellValue(Coordinate::stringFromColumnIndex($column_no).$current_row_no, config('enums.order_type')[$value]);
        }
        if ($column_name == 'price' && $row_data['order_type'] == 2) {
            $active_sheet->getStyle(Coordinate::stringFromColumnIndex($column_no).$current_row_no)
                         ->getNumberFormat()
                         ->setFormatCode('#,##0.00_-"$"');
            $active_sheet->getComment(Coordinate::stringFromColumnIndex($column_no).$current_row_no)
                         ->getText()
                         ->createTextRun(round($row_data['price'] * 0.91, 2).' €');
        }
    }
}
