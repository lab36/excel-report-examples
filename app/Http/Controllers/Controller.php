<?php

namespace App\Http\Controllers;

use App\ExcelReport\DailyConstructionReport;
use App\ExcelReport\InvoicesReport;
use App\ExcelReport\JobEstimateReport;
use App\ExcelReport\MonthlySalesReport;
use App\ExcelReport\OrdersReport;
use App\ExcelReport\SalesReport;
use Carbon\Carbon;
use Faker\Factory;
use Lab36\ExcelReport\ExcelReportLightSalmonTheme;

class Controller
{

    public function exportDailyConstruction()
    {
        $faker = Factory::create();

        for ($i = 0; $i < 100; $i++) {
            $report_line['position'] = $faker->jobTitle;
            $report_line['name'] = $faker->lastName.' '.$faker->firstName;
            $report_line['hours_worked'] = $faker->numberBetween(1, 8);
            $report_line['description'] = $faker->text(40);
            $report_line['project_name'] = 'project '.$faker->name;

            $data[] = $report_line;
        }

        return DailyConstructionReport::fromArray('Daily construction report', $data)
                                      ->setTitleRowNo(2)
                                      ->setFilterRowNo(5)
                                      ->setHeaderRowNo(6)
                                      ->download();
    }


    public function exportJobEstimate()
    {
        $faker = Factory::create();

        $total_sum = 0;
        for ($i = 0; $i < 30; $i++) {
            $report_line['name'] = $faker->jobTitle;
            $report_line['area_size'] = $faker->numberBetween(50, 200);
            $report_line['price'] = $faker->numberBetween(60, 200);
            $report_line['total'] = $report_line['area_size'] * $report_line['price'];

            $total_sum += $report_line['total'];
            $data[] = $report_line;
        }

        $data[] = [
            'name' => 'Total',
            'area_size' => '',
            'price' => '',
            'total' => $total_sum,
        ];

        return JobEstimateReport::fromCollection('Job estimate report', collect($data))
                                ->download();
    }


    public function exportSales()
    {
        $faker = Factory::create();

        for ($i = 0; $i < 30; $i++) {
            $report_line['country'] = $faker->country;
            $report_line['country_code'] = $faker->countryCode;
            $report_line['total_count'] = $faker->numberBetween(1000, 30000);
            $report_line['sales_count'] = $faker->numberBetween(100, 1000);
            $report_line['sales_percent'] = $faker->randomFloat(2, 0.5, 4);
            $report_line['total_just_value'] = $faker->numberBetween(100000, 999999);
            $report_line['total_sales_just_value'] = $faker->numberBetween(10000, 99999);
            $report_line['currency'] = 'euro';

            $data[] = $report_line;
        }


        return SalesReport::fromCollection('Sales report', collect($data))
                          ->setTheme(new ExcelReportLightSalmonTheme())
                          ->download('Sales '.Carbon::now()->toDateString());
    }


    public function exportOrders()
    {
        $faker = Factory::create();

        $filters['order_date'] = '1995-01-01';
        $filters['quantity'] = 4;
        for ($i = 0; $i < 100; $i++) {
            $report_line['order_no'] = '10'.$i;
            $report_line['product_name'] = $faker->name;
            $report_line['order_details'] = $faker->text(100);
            $report_line['sku'] = $faker->countryCode().$i;
            $report_line['order_type'] = $faker->numberBetween(0, 2);
            $report_line['order_date'] = $faker->date();
            $report_line['delivery_date'] = $faker->date();
            $report_line['quantity'] = $faker->numberBetween(1, 5);
            $report_line['price'] = $faker->numberBetween(100, 1000);

            $data[] = $report_line;
        }

        $data = array_filter($data, function ($d) {
            return $d['order_date'] >= '1995-01-01';
        });

        $filtered_data = array_filter($data, function ($d) {
            return $d['quantity'] == '4';
        });

        return OrdersReport::fromArray('Orders report', $filtered_data)
                           ->setFilters($filters)
                           ->setTheme(new ExcelReportLightSalmonTheme())
                           ->download('Orders '.Carbon::now()->toDateString());
    }


    public function exportMonthlySales()
    {
        $faker = Factory::create();
        $no_of_months = rand(3, 10);
        $filters['from_month'] = Carbon::createFromFormat('Y-m', date('Y').'-01')->format('Y-m');
        $filters['to_month'] = Carbon::createFromFormat('Y-m', date('Y').'-'.$no_of_months)->format('Y-m');

        $columns['service'] = 'Service';
        for ($i = 1; $i <= $no_of_months; $i++) {
            $columns[$i] = Carbon::createFromFormat('Y-m', date('Y').'-'.$i)->format('Y-m');
        }

        for ($i = 0; $i < 30; $i++) {
            foreach ($columns as $index => $column) {
                $report_line[$index] = $faker->numberBetween(1000, 20000);

                if ($index === 'service') {
                    $report_line[$index] = $faker->jobTitle;
                }
            }

            $data[] = $report_line;
        }

        return MonthlySalesReport::fromOtherArray(
            'Orders report',
            $data,
            $columns)
                                 ->setFilters($filters)
                                 ->setTheme(new ExcelReportLightSalmonTheme())
                                 ->download('Monthly sales '.$filters['from_month'].'/'.$filters['to_month']);
    }


    public function exportInvoices()
    {
        $faker = Factory::create();

        for ($i = 0; $i < 100; $i++) {
            $report_line['client_name'] = $faker->name;
            $report_line['invoice_serial'] = 'INV';
            $report_line['invoice_number'] = '231'.$i;
            $report_line['invoice_date'] = Carbon::today()->format('Y-m-d');
            $report_line['services'] = [
                'id' => $i,
                'name' => $faker->jobTitle,
                'cod' => $i.'252',
            ];
            $report_line['amount'] = $faker->numberBetween(30, 150);

            $data[] = $report_line;
        }

        return InvoicesReport::fromArray('Invoices report', $data)
                             ->download();
    }
}
