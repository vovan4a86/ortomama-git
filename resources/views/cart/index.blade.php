@extends('template')
@section('content')
    <title>Корзина</title>
    @include('blocks.bread')
    <main>
        <section class="cart">
            <div class="cart__container container">
                <div class="cart__title centered">Корзина</div>
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
                    <!-- row --body-->
                    <div class="tbl-order__row tbl-order__row--body">
                        <div class="tbl-order__col tbl-order__col--pic">
                            <a class="tbl-order__preview" href="javascript:void(0)" title="Открыть товар">
                                <img class="lazy" src="/" data-src="static/images/common/store.png" width="40" height="40" alt="">
                            </a>
                        </div>
                        <div class="tbl-order__col tbl-order__col--name">
                            <span>Lassie Samico Кроссовки 111441 Синий в Екатеринбурге, 111441, Кроссовки, Мокасины, Кеды</span>
                        </div>
                        <div class="tbl-order__col tbl-order__col--count">
                            <div class="counter" data-counter>
                                <button class="counter__btn counter__btn--prev btn-reset">
                                    <svg width="8" height="14" viewBox="0 0 8 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path opacity="0.4" d="M7.15685 1.34315L1.5 7L7.15685 12.6569" stroke="#4A4A4A" />
                                    </svg>

                                </button>
                                <input class="counter__input" type="number" name="count" value="1" data-count>
                                <button class="counter__btn counter__btn--next btn-reset">
                                    <svg width="8" height="14" viewBox="0 0 8 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path opacity="0.4" d="M1.15687 1.34315L6.81372 7L1.15687 12.6569" stroke="#4A4A4A" />
                                    </svg>

                                </button>
                            </div>
                        </div>
                        <div class="tbl-order__col tbl-order__col--price">
                            <span>2 999</span>
                        </div>
                        <div class="tbl-order__col tbl-order__col--discount">
                            <span>200</span>
                        </div>
                        <div class="tbl-order__col tbl-order__col--total">
                            <span>2 799</span>
                        </div>
                    </div>
                    <!-- row --body-->
                    <div class="tbl-order__row tbl-order__row--body">
                        <div class="tbl-order__col tbl-order__col--pic">
                            <a class="tbl-order__preview" href="javascript:void(0)" title="Открыть товар">
                                <img class="lazy" src="/" data-src="static/images/common/store.png" width="40" height="40" alt="">
                            </a>
                        </div>
                        <div class="tbl-order__col tbl-order__col--name">
                            <span>Lassie Samico Кроссовки 111441 Синий в Екатеринбурге, 111441, Кроссовки, Мокасины, Кеды</span>
                        </div>
                        <div class="tbl-order__col tbl-order__col--count">
                            <div class="counter" data-counter>
                                <button class="counter__btn counter__btn--prev btn-reset">
                                    <svg width="8" height="14" viewBox="0 0 8 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path opacity="0.4" d="M7.15685 1.34315L1.5 7L7.15685 12.6569" stroke="#4A4A4A" />
                                    </svg>

                                </button>
                                <input class="counter__input" type="number" name="count" value="1" data-count>
                                <button class="counter__btn counter__btn--next btn-reset">
                                    <svg width="8" height="14" viewBox="0 0 8 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path opacity="0.4" d="M1.15687 1.34315L6.81372 7L1.15687 12.6569" stroke="#4A4A4A" />
                                    </svg>

                                </button>
                            </div>
                        </div>
                        <div class="tbl-order__col tbl-order__col--price">
                            <span>2 999</span>
                        </div>
                        <div class="tbl-order__col tbl-order__col--discount">
                            <span>200</span>
                        </div>
                        <div class="tbl-order__col tbl-order__col--total">
                            <span>2 799</span>
                        </div>
                    </div>
                    <!-- row --body-->
                    <div class="tbl-order__row tbl-order__row--body">
                        <div class="tbl-order__col tbl-order__col--pic">
                            <a class="tbl-order__preview" href="javascript:void(0)" title="Открыть товар">
                                <img class="lazy" src="/" data-src="static/images/common/store.png" width="40" height="40" alt="">
                            </a>
                        </div>
                        <div class="tbl-order__col tbl-order__col--name">
                            <span>Lassie Samico Кроссовки 111441 Синий в Екатеринбурге, 111441, Кроссовки, Мокасины, Кеды</span>
                        </div>
                        <div class="tbl-order__col tbl-order__col--count">
                            <div class="counter" data-counter>
                                <button class="counter__btn counter__btn--prev btn-reset">
                                    <svg width="8" height="14" viewBox="0 0 8 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path opacity="0.4" d="M7.15685 1.34315L1.5 7L7.15685 12.6569" stroke="#4A4A4A" />
                                    </svg>

                                </button>
                                <input class="counter__input" type="number" name="count" value="1" data-count>
                                <button class="counter__btn counter__btn--next btn-reset">
                                    <svg width="8" height="14" viewBox="0 0 8 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path opacity="0.4" d="M1.15687 1.34315L6.81372 7L1.15687 12.6569" stroke="#4A4A4A" />
                                    </svg>

                                </button>
                            </div>
                        </div>
                        <div class="tbl-order__col tbl-order__col--price">
                            <span>2 999</span>
                        </div>
                        <div class="tbl-order__col tbl-order__col--discount">
                            <span>200</span>
                        </div>
                        <div class="tbl-order__col tbl-order__col--total">
                            <span>2 799</span>
                        </div>
                    </div>
                    <!-- row --body-->
                    <div class="tbl-order__row tbl-order__row--body">
                        <div class="tbl-order__col tbl-order__col--pic">
                            <a class="tbl-order__preview" href="javascript:void(0)" title="Открыть товар">
                                <img class="lazy" src="/" data-src="static/images/common/store.png" width="40" height="40" alt="">
                            </a>
                        </div>
                        <div class="tbl-order__col tbl-order__col--name">
                            <span>Lassie Samico Кроссовки 111441 Синий в Екатеринбурге, 111441, Кроссовки, Мокасины, Кеды</span>
                        </div>
                        <div class="tbl-order__col tbl-order__col--count">
                            <div class="counter" data-counter>
                                <button class="counter__btn counter__btn--prev btn-reset">
                                    <svg width="8" height="14" viewBox="0 0 8 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path opacity="0.4" d="M7.15685 1.34315L1.5 7L7.15685 12.6569" stroke="#4A4A4A" />
                                    </svg>

                                </button>
                                <input class="counter__input" type="number" name="count" value="1" data-count>
                                <button class="counter__btn counter__btn--next btn-reset">
                                    <svg width="8" height="14" viewBox="0 0 8 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path opacity="0.4" d="M1.15687 1.34315L6.81372 7L1.15687 12.6569" stroke="#4A4A4A" />
                                    </svg>

                                </button>
                            </div>
                        </div>
                        <div class="tbl-order__col tbl-order__col--price">
                            <span>2 999</span>
                        </div>
                        <div class="tbl-order__col tbl-order__col--discount">
                            <span>200</span>
                        </div>
                        <div class="tbl-order__col tbl-order__col--total">
                            <span>2 799</span>
                        </div>
                    </div>
                    <!-- row --footer-->
                    <div class="tbl-order__row tbl-order__row--footer">
                        <div class="tbl-order__col tbl-order__col--pic"></div>
                        <div class="tbl-order__col tbl-order__col--name">Итого:</div>
                        <div class="tbl-order__col tbl-order__col--count">5</div>
                        <div class="tbl-order__col tbl-order__col--price">11 996</div>
                        <div class="tbl-order__col tbl-order__col--discount">800</div>
                        <div class="tbl-order__col tbl-order__col--total">11 196</div>
                    </div>
                </div>
                <div class="cart__row">
                    <div class="cart__subtitle">Выбрать способ оплаты</div>
                    <div class="cart__payments">
                        <label class="radio">
                            <input class="radio__input" type="radio" name="payment" value="Оплата наличными" checked="checked" />
                            <span class="radio__box"></span>Оплата наличными
                        </label>
                        <label class="radio">
                            <input class="radio__input" type="radio" name="payment" value="Безналичный расчет" />
                            <span class="radio__box"></span>Безналичный расчет
                        </label>
                        <label class="radio">
                            <input class="radio__input" type="radio" name="payment" value="Наложенный платеж" />
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
                                    <input class="radio__input" type="radio" name="delivery" value="Забрать в пункте выдачи" checked="checked" />
                                    <span class="radio__box"></span>Забрать в пункте выдачи
                                </label>
                                <label class="radio">
                                    <input class="radio__input" type="radio" name="delivery" value="Доставка СДЭК" />
                                    <span class="radio__box"></span>Доставка СДЭК
                                </label>
                            </div>
                        </div>
                        <div class="cart__map">
                            <div class="shops">
                                <div class="shops__grid">
                                    <div class="shops__data">
                                        <div class="shops__title">Выбрать пункт выдачи:</div>
                                        <div class="shops__select">
                                            <select class="select" name="address" data-map-select>
                                                <!-- https://slimselectjs.com/options-->
                                                <option class="select__option" value="ул. Павла Шаманова, 5/1" data-label="ул. Павла Шаманова, 5/1" data-longitude="60.521576" data-latitude="56.785246">ул. Павла Шаманова, 5/1</option>
                                                <option class="select__option" value="ул. Репина, 103" data-label="ул. Репина, 103" data-longitude="60.540261" data-latitude="56.820262">ул. Репина, 103</option>
                                                <option class="select__option" value="ул. Крестинского, 55/1, литер А" data-label="ул. Крестинского, 55/1, литер А" data-longitude="60.636246" data-latitude="56.792360">ул. Крестинского, 55/1, литер А</option>
                                                <option class="select__option" value="ул. Техническая, 16" data-label="ул. Техническая, 16" data-longitude="60.544204" data-latitude="56.862740">ул. Техническая, 16</option>
                                                <option class="select__option" value="ул. Cулимова, 28" data-label="ул. Cулимова, 28" data-longitude="60.643378" data-latitude="56.861805">ул. Cулимова, 28</option>
                                                <option class="select__option" value="ул. Ломоносова, 34" data-label="ул. Ломоносова, 34" data-longitude="60.594169" data-latitude="56.904054">ул. Ломоносова, 34</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="shops__map" id="map" data-map data-latitude="56.785246" data-longitude="60.521576" data-label="ул. Павла Шаманова, 5/1"></div>
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
                                <input class="cart__input" type="text" name="lastname" placeholder="Фамилия *" required autocomplete="off">
                                <input class="cart__input" type="text" name="firstname" placeholder="Имя *" required autocomplete="off">
                                <input class="cart__input" type="tel" name="phone" placeholder="Телефон *" required autocomplete="off">
                                <input class="cart__input" type="text" name="email" placeholder="E-mail *" required autocomplete="off">
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
                                <textarea class="cart__input" name="delivery-address" rows="4" placeholder="Адрес доставки"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="cart__action">
                    <button class="btn">
                        <span>Оформить заказ</span>
                    </button>
                </div>
            </div>
        </section>
    </main>

@endsection
