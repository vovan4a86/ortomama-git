<?php
namespace App\Http\Controllers;

use DB;
use Fanky\Admin\Models\Catalog;
use Fanky\Admin\Models\Char;
use Fanky\Admin\Models\City;
use Fanky\Admin\Models\Feedback;
use Fanky\Admin\Models\Order as Order;
use Fanky\Admin\Models\Page;
use Fanky\Admin\Models\Product;
use Fanky\Admin\Models\ProductChar;
use Fanky\Admin\Models\Setting;
use Fanky\Admin\Models\Subscriber;
use Illuminate\Http\Request;
use Mail;
use Mailer;

//use Settings;
use Cart;
use Session;
use Settings;
use SiteHelper;
use Validator;

class AjaxController extends Controller
{
    private $fromMail = 'info@ortomama.ru';
    private $fromName = 'OrtoMama';

    //РАБОТА С КОРЗИНОЙ
    public function postAddToCart(Request $request): array
    {
        $id = $request->get('id');
        $count = $request->get('count');
        $size = $request->get('size');

        /** @var Product $product */
        $product = Product::find($id);
        if ($product) {
            $product_item['id'] = $product->id;
            $product_item['name'] = $product->name;
            $product_item['price'] = $product->price;
            $product_item['count'] = $count;
            $product_item['size'] = $size;
            $product_item['sizes'] = $product->sizes->toArray();
            $product_item['discount_delivery'] = $product->getDiscountDelivery();
            $product_item['discount_payment'] = 0;
            $product_item['url'] = $product->url;

            $prodImage = $product->single_image;
            if ($prodImage) {
                $product_item['image'] = $prodImage->thumb(1);
            }

            Cart::add($product_item);
        }
        $header_cart = view('blocks.header_cart')->render();

        return [
            'success' => true,
            'header_cart' => $header_cart,
        ];
    }

    public function postEditCartProduct(Request $request): array
    {
        $id = $request->get('id');
        $count = $request->get('count', 1);
        /** @var Product $product */
        $product = Product::find($id);
        if ($product) {
            $product_item['image'] = $product->showAnyImage();
            $product_item = $product->toArray();
            $product_item['count_per_tonn'] = $count;
            $product_item['url'] = $product->url;

            Cart::add($product_item);
        }

        $popup = view('blocks.cart_popup', $product_item)->render();

        return ['cart_popup' => $popup];
    }

    public function postUpdateToCart(Request $request): array
    {
        $id = $request->get('id');
        $count = $request->get('count');

        $product = Product::find($id);
        $product_item['count'] = $count;

        Cart::updateCount($id, $count);

        $cart = Cart::all();

        $price = view('cart.cart_item_price', ['item' => $cart[$id]])->render();
        $price_total = view('cart.cart_item_price_total', ['item' => $cart[$id]])->render();
        $footer_total = view('cart.footer_total')->render();

        return [
            'success' => true,
            'price' => $price,
            'price_total' => $price_total,
            'footer_total' => $footer_total,
        ];
    }

    public function postRemoveFromCart(Request $request): array
    {
        $id = $request->get('id');
        Cart::remove($id);
        $total = view('cart.table_row_total')->render();
        $header_cart = view('blocks.header_cart', ['innerPage' => true])->render();
        return [
            'success' => true,
            'total' => $total,
            'header_cart' => $header_cart
        ];
    }

    public function postPurgeCart(): array
    {
        Cart::purge();
        $footer_total = view('cart.footer_total')->render();
        $header_cart = view('blocks.header_cart')->render();
        return [
            'success' => true,
            'footer_total' => $footer_total,
            'header_cart' => $header_cart
        ];
    }

    //применение скидок в зависимости от способа оплаты/доставки
    public function postApplyDiscountPayment()
    {
        $items = Cart::all();
        $view_items = [];

        foreach ($items as $item) {
            $product = Product::find($item['id']);
            $discount = $product->getDiscountPayment();
            Cart::updateDiscountPayment($item['id'], $discount);
            $updated_item = Cart::getItem($item['id']);

            $view_items[] = view('cart.cart_item', ['item' => $updated_item])->render();
        }

        $footer_total = view('cart.footer_total')->render();

        return [
            'success' => true,
            'items' => $view_items,
            'footer_total' => $footer_total
        ];
    }

    public function postDiscardDiscountPayment()
    {
        $items = Cart::all();
        $view_items = [];
        foreach ($items as $item) {
            $discount = 0;
            Cart::updateDiscountPayment($item['id'], $discount);
            $updated_item = Cart::getItem($item['id']);

            $view_items[] = view('cart.cart_item', ['item' => $updated_item])->render();
        }

        $footer_total = view('cart.footer_total')->render();

        return [
            'success' => true,
            'items' => $view_items,
            'footer_total' => $footer_total
        ];
    }

    public function postApplyDiscountDelivery()
    {
        $items = Cart::all();
        $view_items = [];

        foreach ($items as $item) {
            $product = Product::find($item['id']);
            $discount = $product->getDiscountDelivery();
            Cart::updateDiscountDelivery($item['id'], $discount);
            $updated_item = Cart::getItem($item['id']);

            $view_items[] = view('cart.cart_item', ['item' => $updated_item])->render();
        }

        $footer_total = view('cart.footer_total')->render();

        return [
            'success' => true,
            'items' => $view_items,
            'footer_total' => $footer_total
        ];
    }

    public function postDiscardDiscountDelivery()
    {
        $items = Cart::all();
        $view_items = [];
        foreach ($items as $item) {
            $discount = 0;
            Cart::updateDiscountDelivery($item['id'], $discount);
            $updated_item = Cart::getItem($item['id']);

            $view_items[] = view('cart.cart_item', ['item' => $updated_item])->render();
        }

        $footer_total = view('cart.footer_total')->render();

        return [
            'success' => true,
            'items' => $view_items,
            'footer_total' => $footer_total
        ];
    }

    //заказать сейчас/оставить заявку
    public function postRequest(Request $request)
    {
        $data = $request->only(['name', 'email', 'text']);
        $valid = Validator::make($data, [
            'name' => 'required',
            'email' => 'required',
        ], [
            'name.required' => 'Не заполнено поле Имя',
            'email.required' => 'Не заполнено поле Телефон',
        ]);

        if ($valid->fails()) {
            return ['errors' => $valid->messages()];
        } else {
            $feedback_data = [
                'type' => 1,
                'data' => $data
            ];
            $feedback = Feedback::create($feedback_data);
            Mail::send('mail.feedback', ['feedback' => $feedback], function ($message) use ($feedback) {
                $title = $feedback->id . ' | Заявка | OrtoMama';
                $message->from($this->fromMail, $this->fromName)
                    ->to(Settings::get('feedback_email'))
                    ->subject($title);
            });

            return ['success' => true];
        }
    }

    //подписка
    public function postSubscribe(Request $request)
    {
        $data = $request->only('email');
        $valid = Validator::make($data, [
            'email' => 'required'
        ], [
            'email.required' => 'Не заполнено поле Email'
        ]);

        if ($valid->fails()) {
            return ['errors' => $valid->messages()];
        } else {
            $feedback_data = [
                'type' => 2,
                'data' => $data
            ];

            $subscriber = Subscriber::whereEmail($data['email'])->first();
            if(!$subscriber) {
                $feedback = Feedback::create($feedback_data);
                Subscriber::create($data);

                Mail::send('mail.feedback', ['feedback' => $feedback], function ($message) use ($feedback) {
                    $title = $feedback->id . ' | Новый подписчик | OrtoMama';
                    $message->from($this->fromMail, $this->fromName)
                        ->to(Settings::get('feedback_email'))
                        ->subject($title);
                });

                return ['success' => true];
            } else {
                return ['success' => false, 'msg' => 'Вы уже подписаны на нашу рассылку.'];
            }

        }
    }

    //ОФОРМЛЕНИЕ ЗАКАЗА
    public function postSendForm(Request $request)
    {
        $data = $request->only([
            'lastname',
            'firstname',
            'phone',
            'email',
            'address',
        ]);

        $data['payment_id'] = $request->get('payment');
        $data['delivery_id'] = $request->get('delivery');
        $data['point_id'] = $request->get('point');
        $data['sxgeo_region_id'] = $request->get('region');
        $data['city_id'] = $request->get('city');

        array_get($data, 'callback') == 'on' ? $data['callback'] = 1 : $data['callback'] = 0;

        $messages = array(
            'lastname.required' => 'Не заполнено поле Фамилия',
            'firstname.required' => 'Не заполнено поле Имя',
            'phone.required' => 'Не заполнено поле Телефон',
            'email.required' => 'Не выбран способ Email',
            'region.required' => 'Не заполнено поле Область',
            'city.required' => 'Не заполнено поле Город',
            'point.required' => 'Не заполнено поле Адрес пункта выдачи',
            'address.required' => 'Не заполнено поле Адрес доставки'
        );

        $valid = Validator::make($data, [
            'lastname' => 'required',
            'firstname' => 'required',
            'phone' => 'required',
            'email' => 'required',
            'point_id' => 'required_if:delivery,1',
            'sxgeo_region_id' => 'required_if:delivery,2',
            'city_id' => 'required_if:delivery,2',
            'address' => 'required_if:delivery,2'
        ], $messages);
        if ($valid->fails()) {
            return ['errors' => $valid->messages()];
        }

        $data['summ'] = Cart::sum();
        $data['discount_delivery'] = Cart::discount_delivery();
        $data['discount_payment'] = Cart::discount_payment();

        $order = Order::create($data);
        $items = Cart::all();

        foreach ($items as $item) {
            $itemPrice = $item['price'] * $item['count'];
            $order->products()->attach($item['id'], [
                'count' => $item['count'],
                'price' => $itemPrice,
                'discount_delivery' => $item['discount_delivery'],
                'discount_payment' => $item['discount_payment']
            ]);
        }

        $order_items = $order->products;
        $all_count = 0;
        $all_summ = 0;
        $all_discount = 0;
        foreach ($order_items as $item) {
            $all_summ += $item->pivot->price;
            $all_count += $item->pivot->count;
            $all_discount += $item->pivot->discount_payment + $item->pivot->discount_delivery;
        }

        Mail::send('mail.new_order_table', [
            'order' => $order,
            'items' => $order_items,
            'all_count' => $all_count,
            'all_summ' => $all_summ,
            'all_discount' => $all_discount,
        ], function ($message) use ($order) {
            $title = $order->id . ' | Новый заказ | OrtoMama';
            $message->from($this->fromMail, $this->fromName)
                ->to(Settings::get('feedback_email'))
                ->subject($title);
        });

        Cart::purge();

        return ['success' => true];
    }

    public function search(Request $request)
    {
        $data = $request->only(['search']);

        $items = null;

        $page = Page::getByPath(['search']);
        $bread = $page->getBread();

        return [
            'success' => true,
            'redirect' => url('/search', [
                'bread' => $bread,
                'items' => $items,
                'data' => $data,
            ])
        ];

//        return view('search.index', [
//            'bread' => $bread,
//            'items' => $items,
//            'data' => $data,
//        ]);

    }

    public function changeProductsPerPage(Request $request)
    {
        $count = $request->only('num');

        $setting = Setting::find(9);
        if ($setting) {
            $setting->value = $count['num'];
            $setting->save();
            return ['result' => true];
        } else {
            return ['result' => false];
        }
    }

    public function postSetView($view)
    {
        $view = $view == 'list' ? 'list' : 'grid';
        session(['catalog_view' => $view]);

        return ['success' => true];
    }

    public function postUpdateProductCharValue(Request $request): array
    {
        $id = $request->get('char');
        $product_id = $request->get('product');
        $value = $request->get('value');

        ProductChar::where('product_id', $product_id)
            ->where('char_id', $id)->update(['value' => $value]);

        return ['success' => true];
    }

    public function postAddProductChar(Request $request): array
    {
        $data = $request->only(['id', 'name', 'value']);

        $valid = Validator::make($data, [
            'id' => 'required',
            'name' => 'required',
            'value' => 'required',
        ], [
            'id.required' => 'Не указан id продукта',
            'name.required' => 'Не заполнено поле Название',
            'value.required' => 'Не заполнено поле Значение',
        ]);

        if ($valid->fails()) {
            return ['errors' => $valid->messages()];
        } else {
            $char = Char::where('name', $data['name'])->first();
            if (!$char) {
                $char = Char::create([
                    'name' => $data['name']
                ]);
            }
            ProductChar::create([
                'product_id' => $data['id'],
                'char_id' => $char->id,
                'value' => $data['value'],
                'order' => ProductChar::where('product_id', $data['id'])->max('order') + 1
            ]);

            $product = Product::find($data['id']);
            $ch = $product->chars()->where('char_id', $char->id)->first();
            $item = view('admin::catalog.tabs.char_row', ['ch' => $ch, 'product' => $product])->render();

            return ['success' => true, 'item' => $item];
        }
    }

    public function postDeleteProductChar(Request $request): array
    {
        $char_id = $request->get('char');
        $product_id = $request->get('product');

        $id = ProductChar::where('product_id', $product_id)->where('char_id', $char_id)->first()->delete();
        if ($id) {
            return ['success' => true];
        } else {
            return ['success' => false, 'errors' => ['Не удалось удалить характеристику']];
        }
    }

    public function postPerPageSelect(): array
    {
        $count = request()->get('count');
        if (!$count) {
            return ['success' => false, 'error' => '!$count'];
        }

        session(['per_page' => $count]);
        return ['success' => true];
    }

    public function postGetProducts()
    {
        $prods = Product::public()->get();
        $res = [];

        foreach ($prods as $prod) {
            $res[] = [
                'id' => $prod->id,
                'image' => $prod->image()->first()->thumb(2),
                'title' => $prod->name,
                'data' => [
                    [
                        'key' => 'Количество',
                        'value' => 1
                    ],
                    [
                        'key' => 'Цена',
                        'value' => $prod->price . ' руб.'
                    ]
                ]
            ];
        }

        return response()->json($res);
    }

}
