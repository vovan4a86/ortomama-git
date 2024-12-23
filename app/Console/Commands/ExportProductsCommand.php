<?php

namespace App\Console\Commands;

use Fanky\Admin\Models\Product;
use Illuminate\Console\Command;

class ExportProductsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'export:products';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Daily export products';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $path = public_path('export/ortomama-price.xlsx');
        if(!is_dir(dirname($path))){
            mkdir(dirname($path), 0777, true);
        }

        function productGenerator(){
            $products = Product::query()
                ->with(['catalog', 'additional_catalogs', 'catalog.parent',
                        'catalog.parent.parent', 'catalog.parent.parent.parent',
                        'catalog.parent.parent.parent.parent'])
                ->get();

            foreach($products as $product){
                yield $product;
            }

        }


        return (new FastExcel(productGenerator()))
            ->export($path, function ($product) {
                $_parents = $this->getParents($product, true);
                $parent1 = array_get($_parents, 0);
                $parent2 = array_get($_parents, 1);
                $parent3 = array_get($_parents, 2);
                $parent4 = array_get($_parents, 3);
                $parent5 = array_get($_parents, 4);

                return [
                    'ID' => $product->id,
                    'Уровень 1' => $parent1 ? $parent1->name: '',
                    'Уровень 2' => $parent2 ? $parent2->name: '',
                    'Уровень 3' => $parent3 ? $parent3->name: '',
                    'Уровень 4' => $parent4 ? $parent4->name: '',
                    'Уровень 5' => $parent5 ? $parent5->name: '',
                    'Название' => $product->name,

                    'Размер' => $product->size,
                    'Стенка' => $product->wall,
                    'Сталь' => $product->steel,
//
                    'Тип' => $product->type,
                    'Бренд' => $product->brand,
                    'Модель' => $product->model,
                    'Диаметр' => $product->diameter,
                    'РУ' => $product->py,
                    'Коммент.' => $product->comment,
                    'ГОСТ' => $product->gost,

                    'Измер. 1' => $product->measure,
                    'Измер. 2' => $product->measure2,

                    'Цена, т' => $product->price,
                    'Цена, шт' => $product->price_per_item,
                    'Цена, м' => $product->price_per_metr,
                    'Цена, кг' => $product->price_per_kilo,
                    'Цена, м2' => $product->price_per_m2,
                    'Цена, уп' => $product->price_per_pack,
                    'Цена, тыс.шт' => $product->price_per_thousand,
                    'Цена, км' => $product->price_per_km,
                    'Наличие' => $product->in_stock,
                    'Доп.разделы' =>implode(',', $product->additional_catalogs->pluck('id')->toArray()),
                    'Длина' => $product->length
                ];
            });
    }

    private function getParents($product, $reverse = false) {
        $parents = [];
        $parent = $product->catalog;
        while($parent){
            $parents[] = $parent;
            $parent = $parent->parent;
        }
        if ($reverse) {
            $parents = array_reverse($parents);
        }

        return $parents;
    }
}
