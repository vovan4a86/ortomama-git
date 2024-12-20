<?php namespace App\Providers;

use Fanky\Admin\Models\Brand;
use Fanky\Admin\Models\Catalog;
use Fanky\Admin\Models\Point;
use Fanky\Admin\Models\Review;
use Fanky\Admin\Models\Season;
use Fanky\Admin\Models\Gender;
use Fanky\Admin\Models\Size;
use Fanky\Admin\Models\Type;
use Cache;
use Illuminate\Support\ServiceProvider;
use View;
use Cart;
use Fanky\Admin\Models\Page;

class SiteServiceProvider extends ServiceProvider {

	/**
	 * Bootstrap any application services.
	 *
	 * @return void
	 */
	public function boot() {
		// пререндер для шаблона
		View::composer(['template'], function (\Illuminate\View\View $view) {
		    $catalogMenu = Cache::get('catalog_menu', collect());
            if(!count($catalogMenu)) {
                $catalogMenu = Catalog::getTopLevel();
                Cache::add('catalog_menu', $catalogMenu, now()->addMinutes(60));
            }

            $topMenu = Cache::get('top_menu', collect());
            if(!count($topMenu)) {
                $topMenu = Page::query()
                    ->public()
                    ->where('on_top_menu', 1)
                    ->orderBy('order')
                    ->get();
                Cache::add('top_menu', $topMenu, now()->addMinutes(60));
            }

            $mobileMenu = Cache::get('mobile_menu', collect());
            if(!count($mobileMenu)) {
                $mobileMenu = Page::query()
                    ->public()
                    ->where('parent_id', 1)
                    ->where('on_mobile_menu', 1)
                    ->orderBy('order')
                    ->get();
                Cache::add('mobile_menu', $mobileMenu, now()->addMinutes(60));
            }

            $footerCatalog = Cache::get('footer_catalog', collect());
            if(!count($footerCatalog)) {
                $footerCatalog = Catalog::public()
                    ->where('on_footer_menu', 1)
                    ->where('parent_id', 0)
                    ->orderBy('order')
                    ->get();
                Cache::add('footer_catalog', $footerCatalog, now()->addMinutes(60));
            }

            $footerMenu = Cache::get('footer_menu', collect());
            if(!count($footerMenu)) {
                $footerMenu = Page::query()
                    ->public()
                    ->where('parent_id', 1)
                    ->where('on_footer_menu', 1)
                    ->orderBy('order')
                    ->get();
                Cache::add('footer_menu', $footerMenu, now()->addMinutes(60));
            }

			$view->with(compact(
                'topMenu',
                'mobileMenu',
                'footerMenu',
                'footerCatalog'
            ));
		});

        View::composer(
            ['catalog.blocks.product_aside'],
            function ($view) {
                $categories = Cache::get('categories', collect());
                if (!count($categories)) {
                    $categories = Catalog::public()
                        ->where('parent_id', 0)
                        ->orderBy('order')
                        ->get();
                    Cache::add('categories', $categories, now()->addMinutes(60));
                }

                $view->with(
                    compact(
                        'categories'
                    )
                );
            }
        );

        View::composer(
            ['catalog.blocks.catalog_aside'],
            function ($view) {
                $categories = Cache::get('categories', collect());
                if (!count($categories)) {
                    $categories = Catalog::public()
                        ->where('parent_id', 0)
                        ->with(['public_children', 'parent'])
                        ->orderBy('order')
                        ->get();
                    Cache::add('categories', $categories, now()->addMinutes(60));
                }

                $filter_sizes = Cache::get('filter_sizes', collect());
                if (!count($filter_sizes)) {
                    $filter_sizes = Size::query()
                        ->orderBy('value')
                        ->get();
                    Cache::add('filter_sizes', $filter_sizes, now()->addMinutes(60));
                }

                $filter_seasons = Cache::get('filter_seasons', collect());
                if (!count($filter_seasons)) {
                    $filter_seasons = Season::query()
                        ->orderBy('order')
                        ->get();
                    Cache::add('filter_seasons', $filter_seasons, now()->addMinutes(60));
                }

                $filter_brands = Cache::get('filter_brands', collect());
                if (!count($filter_brands)) {
                    $filter_brands = Brand::query()
                        ->orderBy('order')
                        ->get();
                    Cache::add('filter_brands', $filter_brands, now()->addMinutes(60));
                }

                $filter_genders = Cache::get('filter_genders', collect());
                if (!count($filter_genders)) {
                    $filter_genders = Gender::query()
                        ->orderBy('order')
                        ->get();
                    Cache::add('filter_genders', $filter_genders, now()->addMinutes(60));
                }

                $filter_types = Cache::get('filter_types', collect());
                if (!count($filter_types)) {
                    $filter_types = Type::query()
                        ->orderBy('order')
                        ->get();
                    Cache::add('filter_types', $filter_types, now()->addMinutes(60));
                }

                $view->with(
                    compact(
                        'categories',
                        'filter_sizes',
                        'filter_brands',
                        'filter_types',
                        'filter_seasons',
                        'filter_genders'

                    )
                );
            }
        );

        View::composer(
            ['catalog.blocks.points'],
            function ($view) {
                $points = Cache::get('points', collect());
                if (!count($points)) {
                    $points = Point::query()
                        ->orderBy('order')
                        ->get();
                    Cache::add('points', $points, now()->addMinutes(60));
                }

                $view->with(
                    compact(
                        'points'
                    )
                );
            }
        );

        View::composer(
            ['pages.blocks.index_reviews'],
            function ($view) {
                $index_reviews = Cache::get('index_reviews', collect());
                if (!count($index_reviews)) {
                    $index_reviews = Review::public()
                        ->onMain()
                        ->orderBy('order')
                        ->get();
                    Cache::add('index_reviews', $index_reviews, now()->addMinutes(60));
                }

                $view->with(
                    compact(
                        'index_reviews'
                    )
                );
            }
        );

        View::composer(['blocks.header_cart'], function ($view) {
            $items = Cart::all();
            $sum = 0;
            $count = count(Cart::all());
            foreach ($items as $item) {
                $sum += $item['price'];
//                $count += $item['count'];
            }
//            $count .= ' ' . SiteHelper::getNumEnding($count, ['товар', 'товара', 'товаров']);

            $view->with([
                'items' => $items,
                'sum'   => $sum,
                'count' => $count
            ]);
        });
	}

	/**
	 * Register any application services.
	 *
	 * This service provider is a great spot to register your various container
	 * bindings with the application. As you can see, we are registering our
	 * "Registrar" implementation here. You can add your own bindings too!
	 *
	 * @return void
	 */
	public function register() {
		$this->app->singleton('settings', function () {
			return new \App\Classes\Settings();
		});
		$this->app->bind('sitehelper', function () {
			return new \App\Classes\SiteHelper();
		});
		$this->app->alias('settings', \App\Facades\Settings::class);
		$this->app->alias('sitehelper', \App\Facades\SiteHelper::class);
	}
}
