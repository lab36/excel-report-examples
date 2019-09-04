<?php


namespace App\ExcelReport;


use Lab36\ExcelReport\ExcelReport;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SalesReport extends ExcelReport
{
    public function columnMappings(): array
    {
        return [
            'country' => 'Country',
            'total_count' => 'Total Count',
            'sales_count' => 'Sales Count',
            'sales_percent' => 'Sales Percent',
            'total_just_value' => 'Total Just Value',
            'total_sales_just_value' => 'Total Sales Just Value',
        ];
    }


    public function columnFormats(): array
    {
        return [
            'total_count' => 'NUMERIC_FORMATTED',
            'sales_count' => 'NUMERIC_FORMATTED',
            'sales_percent' => 'NUMERIC_FORMATTED',
            'total_just_value' => 'FORMAT_CURRENCY_EUR_SIMPLE',
            'total_sales_just_value' => 'FORMAT_CURRENCY_EUR_SIMPLE',
        ];
    }
}
