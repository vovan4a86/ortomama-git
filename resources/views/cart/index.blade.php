@extends('template')
@section('content')
    <title>Корзина</title>
    @include('blocks.bread')
    <main>
        <section class="cart">
            <div class="cart__container container">
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
                    @foreach($items as $item)
                        @include('cart.cart_item')
                    @endforeach
                    <!-- row --footer-->
                    @include('cart.footer_total')
                    </div>
                    <div class="cart__row">
                        <div class="cart__subtitle">Выбрать способ оплаты</div>
                        <div class="cart__payments">
                            <label class="radio">
                                <input class="radio__input" type="radio" name="payment" value="Оплата наличными"
                                       checked="checked"/>
                                <span class="radio__box"></span>Оплата наличными
                            </label>
                            <label class="radio">
                                <input class="radio__input" type="radio" name="payment" value="Безналичный расчет"/>
                                <span class="radio__box"></span>Безналичный расчет
                            </label>
                            <label class="radio">
                                <input class="radio__input" type="radio" name="payment" value="Наложенный платеж"/>
                                <span class="radio__box"></span>Наложенный платеж
                            </label>
                        </div>
                    </div>
                    <div class="cart__row">
                        <div class="cart__subtitle">Доставка</div>
                        <div class="cart__grid">
                            <div class="cart__delivery">
                                <div class="cart__data">
                                    <label class="radio">
                                        <input class="radio__input" type="radio" name="delivery"
                                               value="Забрать в пункте выдачи" checked="checked"/>
                                        <span class="radio__box"></span>Забрать в пункте выдачи
                                    </label>
                                    <label class="radio">
                                        <input class="radio__input" type="radio" name="delivery" value="Доставка СДЭК"/>
                                        <span class="radio__box"></span>Доставка СДЭК
                                    </label>
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
                                                            <option class="select__option" value="{{ $point->address }}"
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
                                        <div class="shops__map" id="map" data-map data-latitude="{{ $points[0]->latitude }}"
                                             data-longitude="{{ $points[0]->longitude }}" data-label="{{ $points[0]->address }}"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="cart__row">
                        <div class="cart__subtitle">Контактные данные</div>
                        <div class="cart__userdata">
                            <div class="cart__client">
                                <div class="cart__fields">
                                    <input class="cart__input" type="text" name="lastname" placeholder="Фамилия *"
                                           required autocomplete="off">
                                    <input class="cart__input" type="text" name="firstname" placeholder="Имя *" required
                                           autocomplete="off">
                                    <input class="cart__input" type="tel" name="phone" placeholder="Телефон *" required
                                           autocomplete="off">
                                    <input class="cart__input" type="text" name="email" placeholder="E-mail *" required
                                           autocomplete="off">
                                </div>
                            </div>
                            <div class="cart__address">
                                <div class="cart__fields">
                                    <!-- https://slimselectjs.com/options-->
                                    <select class="cart__select" name="region" data-select>
                                        <option data-placeholder="true">Область</option>
                                        <option value="Наименование области">Наименование области</option>
                                        <option value="Наименование области">Наименование области</option>
                                        <option value="Наименование области">Наименование области</option>
                                        <option value="Наименование области">Наименование области</option>
                                        <option value="Наименование области">Наименование области</option>
                                        <option value="Наименование области">Наименование области</option>
                                        <option value="Наименование области">Наименование области</option>
                                        <option value="Наименование области">Наименование области</option>
                                        <option value="Наименование области">Наименование области</option>
                                        <option value="Наименование области">Наименование области</option>
                                    </select>
                                    <select class="cart__select" name="city" data-select>
                                        <option data-placeholder="true">Город</option>
                                        <option value="Наименование города">Наименование города</option>
                                        <option value="Наименование города">Наименование города</option>
                                        <option value="Наименование города">Наименование города</option>
                                        <option value="Наименование города">Наименование города</option>
                                        <option value="Наименование города">Наименование города</option>
                                        <option value="Наименование города">Наименование города</option>
                                        <option value="Наименование города">Наименование города</option>
                                        <option value="Наименование города">Наименование города</option>
                                        <option value="Наименование города">Наименование города</option>
                                        <option value="Наименование города">Наименование города</option>
                                    </select>
                                    <textarea class="cart__input" name="delivery-address" rows="4"
                                              placeholder="Адрес доставки"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="cart__action">
                        <button class="btn">
                            <span>Оформить заказ</span>
                        </button>
                    </div>
                @else
                    <div>Ни одного товара еще не добавлено...</div>
                @endif
            </div>
        </section>
    </main>

@endsection
