@extends('template')
@section('content')
    <title>Корзина</title>
    @include('blocks.bread')
    <main>
        <section class="cart">
            <div class="cart__container container">
                <form action="{{ route('ajax.send-form') }}">
                    <div class="cart__title centered">Корзина</div>
                    @if(count($items))
                        <div class="tbl-order">
                            <!-- row --top-->
                            <div class="tbl-order__row tbl-order__row--top">
                                <div class="tbl-order__col tbl-order__col--pic">Фото</div>
                                <div class="tbl-order__col tbl-order__col--name">Товар</div>
                                <div class="tbl-order__col tbl-order__col--count">Количество</div>
                                <div class="tbl-order__col tbl-order__col--price">Цена без скидки, руб.</div>
                                <div class="tbl-order__col tbl-order__col--discount">Скидка, руб.</div>
                                <div class="tbl-order__col tbl-order__col--total">Цена со скидкой, руб.</div>
                            </div>
                            <div class="cart-items">
                                @foreach($items as $item)
                                    @include('cart.cart_item')
                                @endforeach
                            </div>
                            <!-- row --footer-->
                            @include('cart.footer_total')
                        </div>
                        @if(count($payments))
                            <div class="cart__row">
                                <div class="cart__subtitle">Выбрать способ оплаты</div>
                                <div class="cart__payments">
                                    @foreach($payments as $payment)
                                        <label class="radio">
                                            <input class="radio__input" type="radio" name="payment"
                                                   value="{{ $payment->id }}" onchange="paymentChange(this)"
                                                    {{ $loop->iteration === 1 ? 'checked=checked' : null }}/>
                                            <span class="radio__box"></span>{{ $payment->name }}
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                        @if(count($deliveries))
                            <div class="cart__row">
                                <div class="cart__subtitle">Доставка</div>
                                <div class="cart__grid">
                                    <div class="cart__delivery">
                                        <div class="cart__data">
                                            @foreach($deliveries as $delivery)
                                                <label class="radio">
                                                    <input class="radio__input" type="radio" name="delivery"
                                                           value="{{ $delivery->id }}" onchange="deliveryChange(this)"
                                                            {{ $loop->iteration === 1 ? 'checked=checked' : null }}/>
                                                    <span class="radio__box"></span>{{ $delivery->name }}
                                                </label>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="cart__map">
                                        <div class="shops">
                                            <div class="shops__grid">
                                                <div class="shops__data">
                                                    <div class="shops__title">Выбрать пункт выдачи:</div>
                                                    @if (count($points))
                                                        <div class="shops__select">
                                                            <select class="select" name="address" data-map-select>
                                                                <!-- https://slimselectjs.com/options-->
                                                                @foreach($points as $point)
                                                                    <option class="select__option"
                                                                            value="{{ $point->address }}"
                                                                            data-label="{{ $point->address }}"
                                                                            data-longitude="{{ $point->longitude }}"
                                                                            data-latitude="{{ $point->latitude }}">
                                                                        {{ $point->address }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    @else
                                                        <div>Нет пунктов выдачи</div>
                                                    @endif
                                                </div>
                                                <div class="shops__map" id="map" data-map
                                                     data-latitude="{{ $points[0]->latitude }}"
                                                     data-longitude="{{ $points[0]->longitude }}"
                                                     data-label="{{ $points[0]->address }}"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                        <div class="cart__row">
                            <div class="cart__subtitle">Контактные данные</div>
                            <div class="cart__userdata">
                                <div class="cart__client">
                                    <div class="cart__fields">
                                        <input class="cart__input" type="text" name="lastname" placeholder="Фамилия *"
                                               required autocomplete="off">
                                        <input class="cart__input" type="text" name="firstname" placeholder="Имя *"
                                               required
                                               autocomplete="off">
                                        <input class="cart__input" type="tel" name="phone" placeholder="Телефон *"
                                               required
                                               autocomplete="off">
                                        <input class="cart__input" type="text" name="email" placeholder="E-mail *"
                                               required
                                               autocomplete="off">
                                    </div>
                                </div>
                                <div class="cart__address">
                                    <div class="cart__fields">
                                        <!-- https://slimselectjs.com/options-->
                                        @if(count($all_regions))
                                            <select class="cart__select" name="region" data-select>
                                                <option data-placeholder="true">Область</option>
                                                @foreach($all_regions as $region)
                                                    <option value="{{ $region->id }}">{{ $region->name_ru }}</option>
                                                @endforeach
                                            </select>
                                        @endif
                                        @if($all_cities)
                                            <select class="cart__select" name="city" data-select>
                                                <option data-placeholder="true">Город</option>
                                                @foreach($all_cities as $city)
                                                    <option value="{{ $city->id }}">{{ $city->name }}</option>
                                                @endforeach
                                            </select>
                                        @endif
                                        <textarea class="cart__input" name="delivery-address" rows="4"
                                                  placeholder="Адрес доставки"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="cart__action">
                            <button class="btn" type="submit">
                                <span>Оформить заказ</span>
                            </button>
                            <button class="btn reset-form" style="margin-left: 20px; background-color: red;" onclick="purgeCart(this, event)">
                                <span>Очистить корзину</span>
                            </button>
                        </div>
                    @else
                        <div>Ни одного товара не добавлено...</div>
                    @endif
                </form>
            </div>
        </section>
    </main>
    <script type="module">
        $(window).on('load', function() {
            //определяем скидки по-умолчанию, radio = безнал + забрать из пункта
            sendAjax('/ajax/apply-discount-payment', {}, function(json) {
                if (json.success) {
                    $('.cart-items').html(json.items);
                    $('.tbl-order__row--footer').html(json.footer_total);
                    initCounter();
                }
            })

            sendAjax('/ajax/apply-discount-delivery', {}, function(json) {
                if (json.success) {
                    $('.cart-items').html(json.items);
                    $('.tbl-order__row--footer').html(json.footer_total);
                    initCounter();
                }
            })
        });
    </script>
@endsection
