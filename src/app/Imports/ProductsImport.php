<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use App\Models\Product;
use App\Models\Category;
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

                // Manejo de categorías (columna G)
                if (isset($row['categorias']) && !empty($row['categorias'])) {
                    $this->attachCategoriesToProduct($product, $row['categorias']);
                }

                ++$this->rowsSuccess;
            } else {
                ++$this->rowsError;
            }
        } catch (\Exception $e) {
            ++$this->rowsError;
            Log::error($e->getMessage());
        }

    }

    /**
     * Procesa y adjunta categorías al producto
     *
     * @param Product $product
     * @param string $categoriesString
     */
    private function attachCategoriesToProduct($product, $categoriesString)
    {
        try {
            // Separar categorías por punto y coma
            $categoryNames = explode(';', $categoriesString);

            foreach ($categoryNames as $categoryName) {
                // Quitar espacios al inicio y al final
                $categoryName = trim($categoryName);

                // Saltear si el nombre está vacío después del trim
                if (empty($categoryName)) {
                    continue;
                }

                // Buscar la categoría por nombre
                $category = Category::where('name', $categoryName)->first();

                if ($category) {
                    // Verificar si la categoría ya está asociada al producto para evitar duplicados
                    if (!$product->categories()->where('category_id', $category->id)->exists()) {
                        $product->attachCategory($category->id);
                        Log::info("Categoría '{$categoryName}' adjuntada al producto SKU: {$product->sku}");
                    }
                } else {
                    Log::warning("Categoría '{$categoryName}' no encontrada para el producto SKU: {$product->sku}");
                }
            }
        } catch (\Exception $e) {
            Log::error("Error procesando categorías para producto SKU: {$product->sku}. Error: " . $e->getMessage());
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
