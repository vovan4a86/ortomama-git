@extends('admin::template')

@section('scripts')
    <script type="text/javascript" src="/adminlte/interface_orders.js"></script>
@stop

@section('page_name')
    <h1>Заказ № {{ $order->id }}</h1>
@stop

@section('breadcrumb')
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Главная</a></li>
        <li><a href="{{ route('admin.orders') }}">Заказы</a></li>
        <li class="active">Заказ № {{ $order->id }}</li>
    </ol>
@stop

@section('content')
    <div class="box box-solid">
        <div class="box-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-4 text-bold">Дата заказа</div>
                        <div class="col-md-8">{{ $order->dateFormat() }}</div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 text-bold">Фамилия</div>
                        <div class="col-md-8">{{ $order->lastname }}</div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 text-bold">Имя</div>
                        <div class="col-md-8">{{ $order->firstname }}</div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 text-bold">Телефон</div>
                        <div class="col-md-8">{{ $order->phone }}</div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 text-bold">Email</div>
                        <div class="col-md-8">{{ $order->email }}</div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 text-bold">Сумма без скидки</div>
                        <div class="col-md-8"><strong>{{ number_format($all_summ, 0, '', ' ') }}</strong></div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 text-bold">Общая скидка</div>
                        <div class="col-md-8"><strong>{{ $order->discount_delivery + $order->discount_payment }}</strong></div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-4 text-bold">Оплата</div>
                        <div class="col-md-8">{{ $order->payment->name }}</div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 text-bold">Доставка</div>
                        <div class="col-md-8">{{ $order->delivery->name }}</div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 text-bold">Пункт выдачи</div>
                        @if($order->delivery->id == 1)
                            <div class="col-md-8">{{ $order->point->address . ' ('.$order->point->name.')' }}</div>
                        @else
                            <div class="col-md-8">-</div>
                        @endif
                    </div>
                    <div class="row">
                        <div class="col-md-4 text-bold">Область</div>
                        <div class="col-md-8">{{ $order->sxgeo_region->name_ru }}</div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 text-bold">Город</div>
                        <div class="col-md-8">{{ $order->city->name }}</div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 text-bold">Адрес доставки</div>
                        <div class="col-md-8">{{ $order->address ?: '-' }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="box box-solid">
        <div class="box-body">
            @if (count($items))
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th style="text-align: center;">N</th>
                        <th>Товар</th>
                        <th style="text-align: center;">Количество</th>
                        <th style="text-align: center;">Цена, руб</th>
                        <th style="text-align: center;">Сумма, руб</th>
                        <th style="text-align: center;">Скидка за самовывоз, руб</th>
                        <th style="text-align: center;">Скидка по предоплате, руб</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($items as $item)
                        <tr>
                            <td width="10" style="text-align: center;">{{ $loop->iteration }}</td>
                            <td><a target="_blank"
                                   href="{{ route('admin.catalog.productEdit', [$item->id]) }}">{{ $item->name }}</a>
                            </td>
                            <td style="text-align: center;">{{ $item->pivot->count }}</td>
                            <td style="text-align: center;">{{ number_format($item->price, 0, '', ' ') }}</td>
                            <td style="text-align: center;">{{ number_format($item->pivot->price, 0, '', ' ') }} </td>
                            <td width="200" style="text-align: center;">{{ $item->pivot->discount_delivery ?: 0 }} </td>
                            <td width="200" style="text-align: center;">{{ $item->pivot->discount_payment ?: 0 }} </td>
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot>
                    <tr>
                        <th></th>
                        <th>Итого:</th>
                        <th style="text-align: center;">{{ $all_count }}</th>
                        <th>{{ '' }}</th>
                        <th style="text-align: center;">{{ number_format($all_summ, 0, '', ' ') }}</th>
                    </tr>
                    </tfoot>
                </table>
            @else
                <p>Нет товаров в заказе!</p>
            @endif
        </div>
    </div>
    {{--
            <div class="box box-solid">
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-4 text-bold">ID платежа</div>
                                <div class="col-md-8">
                                    <a href="{{ route('admin.sberpay.view', [$payment_order->id]) }}">{{ $payment_order->payment_id }}</a>
                                    </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 text-bold">Статус платежа</div>
                                <div class="col-md-8 {{ array_get(\Fanky\Admin\Models\PaymentOrder::$status_colors, $payment_order->status_id) }}">{{ array_get(\Fanky\Admin\Models\PaymentOrder::$statuses, $payment_order->status_id) }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    --}}
@stop
