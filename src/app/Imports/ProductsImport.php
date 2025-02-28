<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use App\Models\Product;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductsImport implements ToModel, WithHeadingRow
{
    private $rows = 0;
    private $rowsSuccess = 0;
    private $rowsError = 0;
    
    public function model(array $row)
    {
        
        ++$this->rows;
        try {
            if($row['promo_active'] == 'SI'){
                $promo_active = true;
            }else{
                $promo_active = false;
            }

            if($row['activo'] == 'SI'){
                $is_active = true;
            }else{
                $is_active = false;
            }
            
            $product = Product::where('sku', $row['sku'])->first();
            if ($product) {
                $product->update([
                    'stock_disponible' => $row['stock_disponible'],
                    'promo_active' => $promo_active,
                    'promo_price' => $row['promo_price'],
                    'promo_text' => $row['promo_text'],
                    'is_active' => $is_active
                ]);
                ++$this->rowsSuccess;
            } else {
                ++$this->rowsError;
            }
        } catch (\Exception $e) {
            ++$this->rowsError;
            Log::error($e->getMessage());
        }

    }

    public function getImportResult()
    {

        return [
            'rows' => $this->rows,
            'rowsSuccess' => $this->rowsSuccess,
            'rowsError' => $this->rowsError
        ];
    }
}