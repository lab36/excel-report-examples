<?php


namespace App\ExcelReport;


use Lab36\ExcelReport\ExcelReport;

class MonthlySalesReport extends ExcelReport
{

    public static function fromOtherArray($title, array $data, array $column_mapping)
    {
        $self = new static();

        return $self->run($title, $data, $column_mapping);
    }


    public function run($title, $data, $column_mapping)
    {
        parent::init($title, $data);
        $this->column_mapping = $column_mapping;
        $this->no_of_columns = count($this->column_mapping);

        return $this;
    }

    public function columnMappings(): array
    {
        return [];
    }
}
