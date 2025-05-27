<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ProductsTemplateExport implements FromCollection,ShouldAutoSize
{
    public function collection()
    {
        $headers = [
            [
                'sku',
                'activo',
                'stock_disponible',
                'promo_active',
                'promo_price',
                'promo_text'
            ]
        ];

        return collect($headers);

    }
}