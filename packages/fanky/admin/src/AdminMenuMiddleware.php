<?php namespace Fanky\Admin;

use Auth;
use Closure;
use Menu;

class AdminMenuMiddleware {

	/**
	 * Run the request filter.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  \Closure                 $next
	 * @return mixed
	 */
	public function handle($request, Closure $next) {
		$cur_user = Auth::user();
		Menu::make('main_menu', function (\Lavary\Menu\Builder $menu) use($cur_user, $request) {
			$menu->add('Структура сайта', ['route' => 'admin.pages', 'icon' => 'fa-sitemap'])
				->active('/admin/pages/*');

			$menu->add('Каталог', ['route' => 'admin.catalog', 'icon' => 'fa-list'])
				->active('/admin/catalog/*');

            $menu->add('Фильтры', ['icon' => 'fa-bars'])
                ->nickname('filters');
            $menu->filters->add('Размер', ['route' => 'admin.sizes', 'icon' => 'fa-arrows-h'])
                ->active('/admin/sizes/*');
            $menu->filters->add('Сезон', ['route' => 'admin.seasons', 'icon' => 'fa-thermometer'])
                ->active('/admin/seasons/*');
            $menu->filters->add('Бренд', ['route' => 'admin.brands', 'icon' => 'fa-tag'])
                ->active('/admin/brands/*');
            $menu->filters->add('Пол', ['route' => 'admin.genders', 'icon' => 'fa-venus-mars'])
                ->active('/admin/genders/*');
            $menu->filters->add('Тип обуви', ['route' => 'admin.types', 'icon' => 'fa-crosshairs'])
                ->active('/admin/types/*');

			$menu->add('Заказы', ['route' => 'admin.orders', 'icon' => 'fa-dollar'])
				->active('/admin/orders/*');

//			$menu->add('Региональность', ['route' => 'admin.cities', 'icon' => 'fa-globe'])
//				->active('/admin/cities/*');

			$menu->add('Пункты выдачи', ['route' => 'admin.points', 'icon' => 'fa-globe'])
				->active('/admin/points/*');

			$menu->add('Способы оплаты', ['route' => 'admin.payments', 'icon' => 'fa-money'])
				->active('/admin/payments/*');

			$menu->add('Способы доставки', ['route' => 'admin.deliveries', 'icon' => 'fa-truck'])
				->active('/admin/deliveries/*');

//			$menu->add('Новости', ['route' => 'admin.complex', 'icon' => 'fa-calendar'])
//				->active('/admin/complex/*');

//			$menu->add('Галереи', ['route' => 'admin.gallery', 'icon' => 'fa-image'])
//				->active('/admin/gallery/*');

			$menu->add('Отзывы', ['route' => 'admin.reviews', 'icon' => 'fa-star'])
				->active('/admin/reviews/*');

			$menu->add('Настройки', ['icon' => 'fa-cogs'])
				->nickname('settings');
			$menu->settings->add('Настройки', ['route' => 'admin.settings', 'icon' => 'fa-gear'])
				->active('/admin/settings/*');

			$menu->settings->add('Редиректы', ['route' => 'admin.redirects', 'icon' => 'fa-retweet'])
				->active('/admin/redirects/*');

			$menu->add('Файловый менеджер', ['route' => 'admin.pages.filemanager', 'icon' => 'fa-file'])
				->active('/admin/pages/filemanager');
		});

		return $next($request);
	}

}
