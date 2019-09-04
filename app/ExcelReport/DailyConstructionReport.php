<?php


namespace App\ExcelReport;


use Lab36\ExcelReport\ExcelReport;

class DailyConstructionReport extends ExcelReport
{
    public function columnMappings(): array
    {
        return [
            'position' => 'Position',
            'name' => 'Name',
            'hours_worked' => 'Hours worked',
            'description' => 'Description',
            'project_name' => 'Project name',
        ];
    }

    public function columnAlignment(): array
    {
        return [
            'name' => 'CENTER',
            'hours_worked' => 'RIGHT',
            'description' => 'LEFT',
        ];
    }

    public function columnWidth(): array
    {
        return [
            'position' => '30',
        ];
    }
}
