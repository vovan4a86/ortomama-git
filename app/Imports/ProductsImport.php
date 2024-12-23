<?php

namespace App\Imports;

use Fanky\Admin\Models\Catalog;
use Fanky\Admin\Models\Product;
use Fanky\Admin\Text;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Artisan;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithProgressBar;
use Maatwebsite\Excel\Events\AfterImport;

class ProductsImport implements ToCollection, WithProgressBar,
                                WithHeadingRow, WithEvents
{
    use Importable;

    private $catalogCache = [];

    public function collection(Collection $rows)
    {
        foreach ($rows as $i => $row) {
            $row_arr = $row->toArray();
            $catalog_name = array_only($row_arr, ['kategoriia']);
            $catalog = $this->getCatalog($catalog_name);
            if(!$catalog)  continue;

            $points_string = $row_arr['gde_kupit'];
            $points = array_map('trim', explode('/', $points_string));
            $size = $row_arr['razmer'];
            $gender = trim(strtolower($row_arr['pol']));
            $brand = trim(strtolower($row_arr['marka']));
            $season = trim(strtolower($row_arr['sezon']));

            $updateData = [
                'catalog_id' => $catalog->id,
                'name' => trim($row_arr['nazvanie']),
                'h1' => trim($row_arr['nazvanie']),
                'alias' => Text::translit($row_arr['nazvanie']),
                'article' => $row_arr['artikulcvet'],
                'price' => $row_arr['cena'],
                'old_price' => $row_arr['staraia_cena'],
                'announce' => $row_arr['kratkoe_opisanie'],
                'text' => $row_arr['polnoe_opisanie'],
                'compensation' => trim(strtolower($row_arr['fss'])) == 'да' ? 1 : 0,
                'in_stock' => trim(strtolower($row_arr['nalicie_na_sklade'])) == 'да' ? 1 : 0,
            ];

            $chars = [
                'Цвет' => trim($row_arr['cvet']),
                'Материал верха' => trim($row_arr['material_verxa']),
                'Материал внутренней части' => trim($row_arr['material_vnutrennei_casti']),
                'Внутренняя стелька, см' => trim($row_arr['sm_vnutrennei_stelki']),
                'Задник' => trim($row_arr['zadnik']),
                'Подошва' => trim($row_arr['podosva']),
                'Полнота взъема' => trim($row_arr['polnota_vzieema']),
                'Ширина ступни' => trim($row_arr['sirina_stupni']),
                'Рекомендации' => trim($row_arr['rekomendacii']),
            ];
            dd($chars);

//            $product = Product::find($row['id'] ?? 0);
//            if(!$product){
//                $product = new Product();
//                $updateData['order'] = $catalog->products()->max('order') + 1;
//            }
//            $product->fill($updateData);
//            if(!$product->alias) $product->alias = $this->generateAlias($product);
//            $product->save();
//            $additional_catalog_ids = explode(',', $additional_catalogs);
//            $additional_catalog_ids = array_map('trim', $additional_catalog_ids);
//            $catalogs = Catalog::whereIn('id', $additional_catalog_ids)->get();
//            $product->additional_catalogs()->sync($catalogs);
        }
    }

    private function getCatalog($path)
    {
        $path = array_values(array_filter($path));
        if(!count($path)) {return null;}
        $key = implode(',', $path);
        if (array_get($this->catalogCache, $key)) {
            return array_get($this->catalogCache, $key);
        }

        $result = null;
        $parent_id = 0;
        foreach ($path as $name) {
            $catalog = Catalog::whereName($name)->whereParentId($parent_id)->first();
            if (!$catalog) {
                $catalog = Catalog::create([
                    'parent_id' => $parent_id,
                    'name' => $name,
                    'h1' => $name,
                    'og_title' => $name,
                    'og_description' => $name,
                    'alias' => Text::translit($name),
                    'title' => $name,
                    'published' => 1,
                    'order' => Catalog::whereParentId($parent_id)->max('order') + 1
                ]);
            } else {
                $catalog->update([
                    'published' => 1,
                    'updated_at' => date('Y-m-d H:i:s')
                ]);
            }
            $parent_id = $catalog->id;
            $result = $catalog;
        }

        $this->catalogCache[$key] = $result;

        return $result;
    }

    private function generateAlias($product): string {
        $result = $alias = Text::translit($product->name);
        $i = 1;
        while(Product::where('catalog_id', $product->catalog_id)->where('alias', $result)->exists()){
            $result = $alias . '_' . $i++;
        }

        return $result;
    }

    public function registerEvents(): array {
        return [
            AfterImport::class => function(AfterImport $event) {
                Artisan::call('export:products');
            }
        ];
    }
}
