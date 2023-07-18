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
            $product_item['url'] = $product->url;

            $prodImage = $product->image()->first();
            if ($prodImage) {
                $product_item['image'] = $prodImage->image_src;
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
        $footer_total = view('cart.footer_total')->render();

        return [
            'success' => true,
            'price' => $price,
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
        $total = view('cart.table_row_total')->render();
        $header_cart = view('blocks.header_cart', ['innerPage' => true])->render();
        return [
            'success' => true,
            'total' => $total,
            'header_cart' => $header_cart
        ];
    }

    //заявка в свободной форме
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

    //заказать звонок
    public function postCallback(Request $request)
    {
        $data = $request->only(['name', 'phone', 'time']);
        $valid = Validator::make($data, [
            'name' => 'required',
            'phone' => 'required',
        ], [
            'name.required' => 'Не заполнено поле Имя',
            'phone.required' => 'Не заполнено поле Телефон',
        ]);

        if ($valid->fails()) {
            return ['errors' => $valid->messages()];
        } else {
            $feedback_data = [
                'type' => 3,
                'data' => $data
            ];
            $feedback = Feedback::create($feedback_data);
            Mail::send('mail.feedback', ['feedback' => $feedback], function ($message) use ($feedback) {
                $title = $feedback->id . ' | Заказать звонок | LEVERING';
                $message->from($this->fromMail, $this->fromName)
                    ->to(Settings::get('feedback_email'))
                    ->subject($title);
            });

            return ['success' => true];
        }
    }

    //консультация с файлом
    public function postProductConsult(Request $request)
    {
        $data = $request->only(['name', 'phone', 'message']);
        $file = $request->file('dfile');
        $valid = Validator::make($data, [
            'name' => 'required',
            'phone' => 'required',
        ], [
            'name.required' => 'Не заполнено поле имя',
            'phone.required' => 'Не заполнено поле телефон',
        ]);

        if ($valid->fails()) {
            return ['errors' => $valid->messages()];
        } else {
            if ($file) {
                $file_name = md5(uniqid(rand(), true)) . '.' . $file->getClientOriginalExtension();
                $file->move(public_path(Feedback::UPLOAD_URL), $file_name);
                $data['file'] = '<a target="_blanc" href=\'' . Feedback::UPLOAD_URL . $file_name . '\'>' . $file_name . '</a>';
            }

            $feedback_data = [
                'type' => 2,
                'data' => $data
            ];

            $feedback = Feedback::create($feedback_data);
            Mail::send('mail.feedback', ['feedback' => $feedback], function ($message) use ($feedback) {
                $title = $feedback->id . ' | Консультация по товару | LEVERING';
                $message->from($this->fromMail, $this->fromName)
                    ->to(Settings::get('feedback_email'))
                    ->subject($title);
            });

            return ['success' => true];
        }
    }

    //получить прайс
    public function postGetPrice(Request $request)
    {
        $data = $request->only(['name', 'email', 'phone']);
        $file = $request->file('fileprice');
        $valid = Validator::make($data, [
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
        ], [
            'name.required' => 'Не заполнено поле имя',
            'email.required' => 'Не заполнено поле email',
            'phone.required' => 'Не заполнено поле телефон',
        ]);

        if ($valid->fails()) {
            return ['errors' => $valid->messages()];
        } else {
            if ($file) {
                $file_name = md5(uniqid(rand(), true)) . '.' . $file->getClientOriginalExtension();
                $file->move(public_path(Feedback::UPLOAD_URL), $file_name);
                $data['file'] = '<a target="_blanc" href=\'' . Feedback::UPLOAD_URL . $file_name . '\'>' . $file_name . '</a>';
            }

            $feedback_data = [
                'type' => 8,
                'data' => $data
            ];

            $feedback = Feedback::create($feedback_data);
            Mail::send('mail.feedback', ['feedback' => $feedback], function ($message) use ($feedback) {
                $title = $feedback->id . ' | Запрос прайс-листа | LEVERING';
                $message->from($this->fromMail, $this->fromName)
                    ->to(Settings::get('feedback_email'))
                    ->subject($title);
            });

            return ['success' => true];
        }
    }

    //запрос менеджеру
    public function postManagerRequest(Request $request)
    {
        $data = $request->only(['name', 'phone', 'email', 'message']);
        $file = $request->file('mfile');
        $valid = Validator::make($data, [
            'name' => 'required',
            'phone' => 'required',
            'email' => 'required',
        ], [
            'name.required' => 'Не заполнено поле Имя',
            'phone.required' => 'Не заполнено поле Телефон',
            'email.required' => 'Не заполнено поле Email',
        ]);

        if ($valid->fails()) {
            return ['errors' => $valid->messages()];
        } else {
            if ($file) {
                $file_name = md5(uniqid(rand(), true)) . '.' . $file->getClientOriginalExtension();
                $file->move(public_path(Feedback::UPLOAD_URL), $file_name);
                $data['file'] = '<a target="_blanc" href=\'' . Feedback::UPLOAD_URL . $file_name . '\'>' . $file_name . '</a>';
            }
            $feedback_data = [
                'type' => 6,
                'data' => $data
            ];
            $feedback = Feedback::create($feedback_data);
            Mail::send('mail.feedback', ['feedback' => $feedback], function ($message) use ($feedback) {
                $title = $feedback->id . ' | Запрос менеджеру | LEVERING';
                $message->from($this->fromMail, $this->fromName)
                    ->to(Settings::get('feedback_email'))
                    ->subject($title);
            });

            return ['success' => true];
        }
    }

    //ОФОРМЛЕНИЕ ЗАКАЗА
    public function postOrder(Request $request)
    {
        $data = $request->only([
            'name',
            'phone',
            'email',
            'company',
            'delivery',
            'city',
            'code',
            'street',
            'home-number',
            'apartment-number',
            'comment',
        ]);

        array_get($data, 'callback') == 'on' ? $data['callback'] = 1 : $data['callback'] = 0;

        $messages = array(
            'name.required' => 'Не заполнено поле Имя',
            'phone.required' => 'Не заполнено поле Телефон',
            'company.required' => 'Не заполнено поле Компания',
            'delivery.required' => 'Не выбран способ доставки',
            'city.required' => 'Не заполнено поле Город',
            'code.required' => 'Не заполнено поле Индекс',
            'street.required' => 'Не заполнено поле Улица',
            'home-number.required' => 'Не заполнено поле Дом',
        );

        $valid = Validator::make($data, [
            'name' => 'required',
            'phone' => 'required',
            'company' => 'required',
            'city' => 'required_if:delivery,1',
            'code' => 'required_if:delivery,1',
            'street' => 'required_if:delivery,1',
            'home-number' => 'required_if:delivery,1',
        ], $messages);
        if ($valid->fails()) {
            return ['errors' => $valid->messages()];
        }

        $data['summ'] = Cart::sum();

        $order = Order::create($data);
        $items = Cart::all();

        foreach ($items as $item) {
            $itemPrice = $item['price'] * $item['count'];
            $order->products()->attach($item['id'], [
                'count' => $item['count'],
                'price' => $itemPrice,
            ]);
        }

        $order_items = $order->products;
        $all_count = 0;
        $all_summ = 0;
        foreach ($order_items as $item) {
            $all_summ += $item->pivot->price;
            $all_count += $item->pivot->count;
        }

        Mail::send('mail.new_order_table', [
            'order' => $order,
            'items' => $order_items,
            'all_count' => $all_count,
            'all_summ' => $all_summ
        ], function ($message) use ($order) {
            $title = $order->id . ' | Новый заказ | LEVERING';
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
