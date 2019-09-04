<?php


namespace App\ExcelReport;


use Lab36\ExcelReport\ExcelReport;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class JobEstimateReport extends ExcelReport
{
    public function columnMappings(): array
    {
        return [
            'name' => 'Name',
            'area_size' => 'Area size(Sq/Ft)',
            'price' => 'Price(Per Sq/Ft)',
            'total' => 'Total',
        ];
    }


    public function columnFormats(): array
    {
        return [
            'price' => 'FORMAT_CURRENCY_USD_SIMPLE',
            'total' => 'FORMAT_CURRENCY_USD_SIMPLE',
        ];
    }


    public function overrideCell(Worksheet $active_sheet, int $current_row_no, int $column_no, string $value, array $row_data, string $column_name)
    {
        if ($row_data['name'] == 'Total') {
            $active_sheet->getStyle(Coordinate::stringFromColumnIndex($column_no).$current_row_no)
                         ->getFont()
                         ->setBold(true);
        }
    }
}
