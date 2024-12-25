<?php

namespace App\Imports;

use Fanky\Admin\Models\Brand;
use Fanky\Admin\Models\Catalog;
use Fanky\Admin\Models\Char;
use Fanky\Admin\Models\Color;
use Fanky\Admin\Models\Gender;
use Fanky\Admin\Models\Point;
use Fanky\Admin\Models\Product;
use Fanky\Admin\Models\Season;
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

    public function collection(Collection $rows)
    {
        foreach ($rows as $i => $row) {
            $row_arr = $row->toArray();

            $catalogs_string = trim($row_arr['kategoriia_ili_spisok_kategorii_razdelennyx']);
            $catalog_names = array_map('trim', explode(';', $catalogs_string));
            $catalogs = [];
            foreach ($catalog_names as $cat_name) {
                $catalog = $this->getCatalog($cat_name);
                $catalogs[] = $catalog;
            }

            $points_string = $row_arr['gde_kupit'];
            $points = array_map('trim', explode('/', $points_string));

            $size = $row_arr['razmer'];
            $color_name = trim($row_arr['cvet']);
            $gender = trim($row_arr['pol']);
            $brand = trim($row_arr['marka']);
            $seasons_string = $row_arr['sezon'];
            $seasons = array_map('trim', explode('/', $seasons_string));

            $updateData = [
                'name' => trim($row_arr['nazvanie']) . ' (' . $row_arr['artikul'] . ') ' . 'р.' . $size,
                'brand_id' => $this->getBrandId($brand),
                'color_id' => $this->getColorId($color_name),
                'h1' => trim($row_arr['nazvanie']),
                'alias' => Text::translit(trim($row_arr['nazvanie']) . '_' . $row_arr['artikul'] . '_' . $size),
                'article' => $row_arr['artikul'],
                'price' => $row_arr['cena'],
                'size' => $size,
                'old_price' => $row_arr['staraia_cena_zacerknutaia'],
                'announce_text' => $row_arr['kratkoe_opisanie'],
                'text' => $row_arr['polnoe_opisanie'],
                'fss' => trim(mb_strtoupper($row_arr['fss'])) === 'ДА' ? 1 : 0,
                'in_stock' => trim(mb_strtoupper($row_arr['nalicie_na_sklade'])) === 'ДА' ? 1 : 0,
            ];

            $chars = [
                'Материал верха' => trim($row_arr['material_verxa']),
                'Материал внутренней части' => trim($row_arr['material_vnutrennei_casti']),
                'Внутренняя стелька, см' => trim($row_arr['sm_vnutrennei_stelki']),
                'Задник' => trim($row_arr['zadnik']),
                'Подошва' => trim($row_arr['podosva']),
                'Полнота взъема' => trim($row_arr['polnota_vzieema']),
                'Ширина ступни' => trim($row_arr['sirina_stupni']),
                'Рекомендации' => trim($row_arr['rekomendacii']),
            ];

            $product = Product::whereArticle($row_arr['artikul'])
                ->whereColorId($updateData['color_id'])
                ->whereSize($size)
                ->first();
            if (!$product) {
                $product = new Product();
                $updateData['order'] = $catalog->products()->max('order') + 1;
            }
            $product->fill($updateData);
            $product->save();

            $this->syncCatalogsWithProduct($catalogs, $product);
            $this->syncPointsWithProduct($product, $points);
            $this->syncGenderWithProduct($product, $gender);
            $this->syncSeasonsWithProduct($product, $seasons);

            foreach ($chars as $name => $value) {
                if ($value) {
                    $ch = Char::whereProductId($product->id)->whereName($name)->first();
                    if (!$ch) {
                        Char::create([
                            'product_id' => $product->id,
                            'name' => $name,
                            'value' => $value,
                            'order' => Char::where('product_id')->max('order') + 1
                        ]);
                    } else {
                        $ch->update(['value' => $value]);
                    }
                }
            }
        }
    }

    private function getCatalog($name)
    {
        $catalog = Catalog::whereName($name)->first();
        if (!$catalog) {
            $catalog = Catalog::create([
                'parent_id' => 0,
                'name' => $name,
                'h1' => $name,
                'og_title' => $name,
                'og_description' => $name,
                'alias' => Text::translit($name),
                'title' => $name,
                'published' => 1,
                'order' => Catalog::whereParentId(0)->max('order') + 1
            ]);
        } else {
            $catalog->update([
                'published' => 1,
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        }

        return $catalog;
    }

    private function generateAlias($product): string
    {
        $result = $alias = Text::translit($product->name);
        $i = 1;
        while (Product::where('catalog_id', $product->catalog_id)->where('alias', $result)->exists()) {
            $result = $alias . '_' . $i++;
        }

        return $result;
    }

    public function registerEvents(): array
    {
        return [
//            AfterImport::class => function(AfterImport $event) {
//                Artisan::call('export:products');
//            }
        ];
    }

    private function syncPointsWithProduct(Product $product, array $points): void
    {
        if (count($points)) {
            $ids = [];
            foreach ($points as $point) {
                $address = $this->getPointAddressFromString($point);
                $p = Point::where('address', $address)->first();
                if (!$p) {
                    $p = Point::create([
                        'name' => $this->getPointNameFromString($point),
                        'address' => $address,
                        'order' => Point::max('order') + 1
                    ]);
                }
                $ids[] = $p->id;
            }
            $product->points()->sync($ids);
        }
    }

    private function syncGenderWithProduct(Product $product, string $gender): void
    {
        if ($gender) {
            $g = Gender::where('value', $gender)->first();
            if (!$g) {
                $g = Gender::create([
                    'value' => $gender,
                    'order' => Gender::max('order') + 1
                ]);
            }
            $product->genders()->sync($g->id);
        }
    }

    private function syncSeasonsWithProduct(Product $product, array $seasons): void
    {
        if (count($seasons)) {
            $ids = [];
            foreach ($seasons as $season) {
                $s = Season::where('value', $season)->first();
                if (!$s) {
                    $s = Season::create([
                        'value' => $season,
                        'order' => Season::max('order') + 1
                    ]);
                }
                $ids[] = $s->id;
            }
            $product->seasons()->sync($ids);
        }
    }

    private function syncCatalogsWithProduct(array $catalogs, Product $product): void
    {
        foreach ($catalogs as $cat) {
            $catalog_product_ids = $cat->products()->pluck('product_id')->all();
            if (!in_array($product->id, $catalog_product_ids)) {
                $cat->products()->attach($product->id);
            }
        }
    }

    private function getPointNameFromString(string $str): string
    {
        $i_start = stripos($str, '(');
        $i_end = stripos($str, ')');

        if ($i_start && $i_end) {
            return substr($str, $i_start + 1, $i_end - $i_start - 1);
        }

        return '-';
    }

    private function getPointAddressFromString(string $str): string
    {
        $i_start = stripos($str, '(');
        $i_end = stripos($str, ')');

        if ($i_start && $i_end) {
            $cut_name = substr($str, $i_start, $i_end - $i_start + 1);
            if ($cut_name) {
                return (trim(str_replace($cut_name, '', $str)));
            }
        }

        return $str;
    }

    private function getBrandId (string $brand)
    {
        if ($brand) {
            $b = Brand::whereValue($brand)->first();
            if (!$b) {
                $b = Brand::create([
                    'value' => $brand,
                    'order' => Brand::max('order') + 1
                ]);
            }
            return $b->id;
        }
        return 0;
    }

    private function getColorId (string $color_name) {
        if($color_name) {
            $color = Color::whereValue($color_name)->first();
            if (!$color) {
                $color = Color::create([
                    'value' => $color_name,
                    'order' => Color::max('order') + 1
                ]);
            }
            return $color->id;
        }
        return 0;
    }
}
