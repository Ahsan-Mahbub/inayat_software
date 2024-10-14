<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use App\Models\Product;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportProduct implements FromCollection
{

    protected $data;

    public function __construct(Collection $data)
    {
        $this->data = $data;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $data = $this->data;

        $customHeadings = [
            'Name/Code',
            'Category',
            'Description',
            'Purchase Price',
            'Sale Price',
        ];

        $rows = collect();

        // Add custom headings as the first row
        $rows->push($customHeadings);

        // Add the data rows
        foreach ($data as $item) {
            $rowData = [
                $item->sku,
                $item->category ? $item->category->category_name : '',
                $item->description ? strip_tags($item->description) : '',
                $item->purchase_price,
                $item->sale_price,
            ];
            $rows->push($rowData);
        }

        return $rows;
    }

    public function headings(): array
    {
        return [];
    }
}
