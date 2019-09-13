<?php


namespace App\ExcelReport;


use Lab36\ExcelReport\ExcelReport;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class InvoicesReport extends ExcelReport
{
    public function columnMappings(): array
    {
        return [
            'client_name' => 'Client',
            'invoice_serial' => 'Serial',
            'invoice_number' => 'Number',
            'invoice_date' => 'Date',
            'services' => 'Service',
            'amount' => 'Amount',
        ];
    }

    public function overrideCell(Worksheet $active_sheet, int $current_row_no, int $column_no, $value, array $row_data, string $column_name)
    {
        if ($column_name == 'services') {
            $active_sheet->setCellValue(Coordinate::stringFromColumnIndex($column_no).$current_row_no, $value['name']);
        }
    }
}
