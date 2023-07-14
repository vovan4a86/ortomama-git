@extends('template')
@section('content')
    @include('blocks.bread')
    <div class="container container--inner">
        @include('catalog.blocks.layout_aside')
        <div class="container__main">
            <main>
                <section class="catalog">
                    <div class="catalog__title">{{ $h1 }}</div>
                    <div class="infos">
                        <div class="infos__row">
                            <div class="infos__column">
                                <div class="infos__label">Товаров в категории:</div>
                                <div class="infos__value">56</div>
                            </div>
                            <div class="infos__column">
                                <div class="infos__label">Показать:</div>
                                <ul class="infos__links">
                                    <li class="infos__item">
                                        <a class="infos__link infos__link--current" href="javascript:void(0)" title="Показать 6">6</a>
                                    </li>
                                    <li class="infos__item">
                                        <a class="infos__link" href="javascript:void(0)" title="Показать 12">12</a>
                                    </li>
                                    <li class="infos__item">
                                        <a class="infos__link" href="javascript:void(0)" title="Показать 24">24</a>
                                    </li>
                                    <li class="infos__item">
                                        <a class="infos__link" href="javascript:void(0)" title="Показать 48">48</a>
                                    </li>
                                    <li class="infos__item">
                                        <a class="infos__link" href="javascript:void(0)" title="Показать Все">Все</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="catalog__list">
                        <div class="catalog__item">
                            <div class="catalog-card">
                                <a class="catalog-card__brand" href="javascript:void(0)" title="Футмастер">Футмастер</a>
                                <div class="catalog-card__id">Арт.:&nbsp;
                                    <span>111441</span>
                                </div>
                                <a class="catalog-card__link" href="javascript:void(0)">
                                    <img class="catalog-card__picture lazy" src="/" data-src="/static/images/common/card-1.jpg" width="330" height="200" alt="">
                                </a>
                                <div class="catalog-card__text">ФУТМАСТЕР Туфли (лечебная антивальгусная обувь) высокие берцы Мальвина 2400-0013 Черный лак</div>
                                <a class="catalog-card__fss" href="ajax-ipr.html" data-fancybox data-type="ajax">
                                    <img class="lazy" src="/" data-src="/static/images/common/fss.png" width="50" height="43" alt="">
                                    <span>Компенсация ФСС</span>
                                </a>
                                <div class="catalog-card__price">Цена от
                                    <span data-end="₽">2 999</span>
                                    <div class="catalog-card__oldprice" data-end="₽">2 999</div>
                                </div>
                                <div class="catalog-card__overlay">
                                    <button class="catalog-card__action btn-reset" type="button">
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="32" height="32" preserveAspectRatio="xMidYMid meet" viewBox="0 0 48 48" style="-ms-transform: rotate(360deg); -webkit-transform: rotate(360deg); transform: rotate(360deg);">
                                            <g fill="none" stroke="currentColor" stroke-linejoin="round" stroke-width="4">
                                                <path d="M21 38c9.389 0 17-7.611 17-17S30.389 4 21 4S4 11.611 4 21s7.611 17 17 17Z" />
                                                <path stroke-linecap="round" d="M26.657 14.343A7.975 7.975 0 0 0 21 12a7.975 7.975 0 0 0-5.657 2.343m17.879 18.879l8.485 8.485" />
                                            </g>
                                        </svg>
                                        <span>Быстрый просмотр</span>
                                    </button>
                                    <button class="catalog-card__action btn-reset" type="button" data-product="10" data-create-order data-src="#create-order" onclick="console.log(this)">
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="32" height="32" preserveAspectRatio="xMidYMid meet" viewBox="0 0 32 32" style="-ms-transform: rotate(360deg); -webkit-transform: rotate(360deg); transform: rotate(360deg);">
                                            <path fill="currentColor" d="M16 3.094L7.094 12H2v6h1.25l2.781 9.281l.219.719h19.5l.219-.719L28.75 18H30v-6h-5.094zm0 2.844L22.063 12H9.938zM4 14h24v2h-.75l-.219.719L24.25 26H7.75l-2.781-9.281L4.75 16H4zm7 3v7h2v-7zm4 0v7h2v-7zm4 0v7h2v-7z"
                                            />
                                        </svg>
                                        <span>Купить</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="catalog__item">
                            <div class="catalog-card">
                                <a class="catalog-card__brand" href="javascript:void(0)" title="Футмастер">Футмастер</a>
                                <div class="catalog-card__id">Арт.:&nbsp;
                                    <span>0013-0013-3</span>
                                </div>
                                <a class="catalog-card__link" href="javascript:void(0)">
                                    <img class="catalog-card__picture lazy" src="/" data-src="/static/images/common/card-2.jpg" width="330" height="200" alt="">
                                </a>
                                <div class="catalog-card__text">ФУТМАСТЕР Туфли (лечебная антивальгусная обувь) высокие берцы Метида липы 0013-0013-3 Черный кожа</div>
                                <a class="catalog-card__fss" href="ajax-ipr.html" data-fancybox data-type="ajax">
                                    <img class="lazy" src="/" data-src="/static/images/common/fss.png" width="50" height="43" alt="">
                                    <span>Компенсация ФСС</span>
                                </a>
                                <div class="catalog-card__price">Цена от
                                    <span data-end="₽">2 496</span>
                                </div>
                                <div class="catalog-card__overlay">
                                    <button class="catalog-card__action btn-reset" type="button">
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="32" height="32" preserveAspectRatio="xMidYMid meet" viewBox="0 0 48 48" style="-ms-transform: rotate(360deg); -webkit-transform: rotate(360deg); transform: rotate(360deg);">
                                            <g fill="none" stroke="currentColor" stroke-linejoin="round" stroke-width="4">
                                                <path d="M21 38c9.389 0 17-7.611 17-17S30.389 4 21 4S4 11.611 4 21s7.611 17 17 17Z" />
                                                <path stroke-linecap="round" d="M26.657 14.343A7.975 7.975 0 0 0 21 12a7.975 7.975 0 0 0-5.657 2.343m17.879 18.879l8.485 8.485" />
                                            </g>
                                        </svg>
                                        <span>Быстрый просмотр</span>
                                    </button>
                                    <button class="catalog-card__action btn-reset" type="button" data-product="10" data-create-order data-src="#create-order" onclick="console.log(this)">
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="32" height="32" preserveAspectRatio="xMidYMid meet" viewBox="0 0 32 32" style="-ms-transform: rotate(360deg); -webkit-transform: rotate(360deg); transform: rotate(360deg);">
                                            <path fill="currentColor" d="M16 3.094L7.094 12H2v6h1.25l2.781 9.281l.219.719h19.5l.219-.719L28.75 18H30v-6h-5.094zm0 2.844L22.063 12H9.938zM4 14h24v2h-.75l-.219.719L24.25 26H7.75l-2.781-9.281L4.75 16H4zm7 3v7h2v-7zm4 0v7h2v-7zm4 0v7h2v-7z"
                                            />
                                        </svg>
                                        <span>Купить</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="catalog__item">
                            <div class="catalog-card">
                                <a class="catalog-card__brand" href="javascript:void(0)" title="Футмастер">Футмастер</a>
                                <div class="catalog-card__id">Арт.:&nbsp;
                                    <span>0201-0011</span>
                                </div>
                                <a class="catalog-card__link" href="javascript:void(0)">
                                    <img class="catalog-card__picture lazy" src="/" data-src="/static/images/common/card-3.jpg" width="330" height="200" alt="">
                                </a>
                                <div class="catalog-card__text">ФУТМАСТЕР Туфли (лечебная антивальгусная обувь) Полуботинки школьные Атлант без утепления 0201-0011 Черный кожа</div>
                                <a class="catalog-card__fss" href="ajax-ipr.html" data-fancybox data-type="ajax">
                                    <img class="lazy" src="/" data-src="/static/images/common/fss.png" width="50" height="43" alt="">
                                    <span>Компенсация ФСС</span>
                                </a>
                                <div class="catalog-card__price">Цена от
                                    <span data-end="₽">3 200</span>
                                </div>
                                <div class="catalog-card__overlay">
                                    <button class="catalog-card__action btn-reset" type="button">
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="32" height="32" preserveAspectRatio="xMidYMid meet" viewBox="0 0 48 48" style="-ms-transform: rotate(360deg); -webkit-transform: rotate(360deg); transform: rotate(360deg);">
                                            <g fill="none" stroke="currentColor" stroke-linejoin="round" stroke-width="4">
                                                <path d="M21 38c9.389 0 17-7.611 17-17S30.389 4 21 4S4 11.611 4 21s7.611 17 17 17Z" />
                                                <path stroke-linecap="round" d="M26.657 14.343A7.975 7.975 0 0 0 21 12a7.975 7.975 0 0 0-5.657 2.343m17.879 18.879l8.485 8.485" />
                                            </g>
                                        </svg>
                                        <span>Быстрый просмотр</span>
                                    </button>
                                    <button class="catalog-card__action btn-reset" type="button" data-product="10" data-create-order data-src="#create-order" onclick="console.log(this)">
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="32" height="32" preserveAspectRatio="xMidYMid meet" viewBox="0 0 32 32" style="-ms-transform: rotate(360deg); -webkit-transform: rotate(360deg); transform: rotate(360deg);">
                                            <path fill="currentColor" d="M16 3.094L7.094 12H2v6h1.25l2.781 9.281l.219.719h19.5l.219-.719L28.75 18H30v-6h-5.094zm0 2.844L22.063 12H9.938zM4 14h24v2h-.75l-.219.719L24.25 26H7.75l-2.781-9.281L4.75 16H4zm7 3v7h2v-7zm4 0v7h2v-7zm4 0v7h2v-7z"
                                            />
                                        </svg>
                                        <span>Купить</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="catalog__item">
                            <div class="catalog-card">
                                <a class="catalog-card__brand" href="javascript:void(0)" title="Мемо">Мемо</a>
                                <div class="catalog-card__id">Арт.:&nbsp;
                                    <span>111441</span>
                                </div>
                                <a class="catalog-card__link" href="javascript:void(0)">
                                    <img class="catalog-card__picture lazy" src="/" data-src="/static/images/common/card-4.png" width="255" height="143" alt="">
                                </a>
                                <div class="catalog-card__text">МЕМО (лечебная антивальгусная обувь) Сандали CINDIRELLA-черный</div>
                                <a class="catalog-card__fss" href="ajax-ipr.html" data-fancybox data-type="ajax">
                                    <img class="lazy" src="/" data-src="/static/images/common/fss.png" width="50" height="43" alt="">
                                    <span>Компенсация ФСС</span>
                                </a>
                                <div class="catalog-card__price">Цена от
                                    <span data-end="₽">3 200</span>
                                </div>
                                <div class="catalog-card__overlay">
                                    <button class="catalog-card__action btn-reset" type="button">
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="32" height="32" preserveAspectRatio="xMidYMid meet" viewBox="0 0 48 48" style="-ms-transform: rotate(360deg); -webkit-transform: rotate(360deg); transform: rotate(360deg);">
                                            <g fill="none" stroke="currentColor" stroke-linejoin="round" stroke-width="4">
                                                <path d="M21 38c9.389 0 17-7.611 17-17S30.389 4 21 4S4 11.611 4 21s7.611 17 17 17Z" />
                                                <path stroke-linecap="round" d="M26.657 14.343A7.975 7.975 0 0 0 21 12a7.975 7.975 0 0 0-5.657 2.343m17.879 18.879l8.485 8.485" />
                                            </g>
                                        </svg>
                                        <span>Быстрый просмотр</span>
                                    </button>
                                    <button class="catalog-card__action btn-reset" type="button" data-product="10" data-create-order data-src="#create-order" onclick="console.log(this)">
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="32" height="32" preserveAspectRatio="xMidYMid meet" viewBox="0 0 32 32" style="-ms-transform: rotate(360deg); -webkit-transform: rotate(360deg); transform: rotate(360deg);">
                                            <path fill="currentColor" d="M16 3.094L7.094 12H2v6h1.25l2.781 9.281l.219.719h19.5l.219-.719L28.75 18H30v-6h-5.094zm0 2.844L22.063 12H9.938zM4 14h24v2h-.75l-.219.719L24.25 26H7.75l-2.781-9.281L4.75 16H4zm7 3v7h2v-7zm4 0v7h2v-7zm4 0v7h2v-7z"
                                            />
                                        </svg>
                                        <span>Купить</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="catalog__item">
                            <div class="catalog-card">
                                <a class="catalog-card__brand" href="javascript:void(0)" title="Сурсил Орто">Сурсил Орто</a>
                                <div class="catalog-card__id">Арт.:&nbsp;
                                    <span>111441</span>
                                </div>
                                <a class="catalog-card__link" href="javascript:void(0)">
                                    <img class="catalog-card__picture lazy" src="/" data-src="/static/images/common/card-5.png" width="371" height="207" alt="">
                                </a>
                                <div class="catalog-card__text">Сурсил-Орто Туфли школьные 141110 Черный</div>
                                <a class="catalog-card__fss" href="ajax-ipr.html" data-fancybox data-type="ajax">
                                    <img class="lazy" src="/" data-src="/static/images/common/fss.png" width="50" height="43" alt="">
                                    <span>Компенсация ФСС</span>
                                </a>
                                <div class="catalog-card__price">Цена от
                                    <span data-end="₽">3 035</span>
                                    <div class="catalog-card__oldprice" data-end="₽">3 570</div>
                                </div>
                                <div class="catalog-card__overlay">
                                    <button class="catalog-card__action btn-reset" type="button">
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="32" height="32" preserveAspectRatio="xMidYMid meet" viewBox="0 0 48 48" style="-ms-transform: rotate(360deg); -webkit-transform: rotate(360deg); transform: rotate(360deg);">
                                            <g fill="none" stroke="currentColor" stroke-linejoin="round" stroke-width="4">
                                                <path d="M21 38c9.389 0 17-7.611 17-17S30.389 4 21 4S4 11.611 4 21s7.611 17 17 17Z" />
                                                <path stroke-linecap="round" d="M26.657 14.343A7.975 7.975 0 0 0 21 12a7.975 7.975 0 0 0-5.657 2.343m17.879 18.879l8.485 8.485" />
                                            </g>
                                        </svg>
                                        <span>Быстрый просмотр</span>
                                    </button>
                                    <button class="catalog-card__action btn-reset" type="button" data-product="10" data-create-order data-src="#create-order" onclick="console.log(this)">
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="32" height="32" preserveAspectRatio="xMidYMid meet" viewBox="0 0 32 32" style="-ms-transform: rotate(360deg); -webkit-transform: rotate(360deg); transform: rotate(360deg);">
                                            <path fill="currentColor" d="M16 3.094L7.094 12H2v6h1.25l2.781 9.281l.219.719h19.5l.219-.719L28.75 18H30v-6h-5.094zm0 2.844L22.063 12H9.938zM4 14h24v2h-.75l-.219.719L24.25 26H7.75l-2.781-9.281L4.75 16H4zm7 3v7h2v-7zm4 0v7h2v-7zm4 0v7h2v-7z"
                                            />
                                        </svg>
                                        <span>Купить</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="catalog__item">
                            <div class="catalog-card">
                                <a class="catalog-card__brand" href="javascript:void(0)" title="МЕГА ОРТОПЕДИК">МЕГА ОРТОПЕДИК</a>
                                <div class="catalog-card__id">Арт.:&nbsp;
                                    <span>Арт.: 0201-0011</span>
                                </div>
                                <a class="catalog-card__link" href="javascript:void(0)">
                                    <img class="catalog-card__picture lazy" src="/" data-src="/static/images/common/card-6.png" width="367" height="293" alt="">
                                </a>
                                <div class="catalog-card__text">МЕГА ОРТОПЕДИК Туфли закрытые 225-128-88 Синий лак</div>
                                <a class="catalog-card__fss" href="ajax-ipr.html" data-fancybox data-type="ajax">
                                    <img class="lazy" src="/" data-src="/static/images/common/fss.png" width="50" height="43" alt="">
                                    <span>Компенсация ФСС</span>
                                </a>
                                <div class="catalog-card__price">Цена от
                                    <span data-end="₽">3 816</span>
                                </div>
                                <div class="catalog-card__overlay">
                                    <button class="catalog-card__action btn-reset" type="button">
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="32" height="32" preserveAspectRatio="xMidYMid meet" viewBox="0 0 48 48" style="-ms-transform: rotate(360deg); -webkit-transform: rotate(360deg); transform: rotate(360deg);">
                                            <g fill="none" stroke="currentColor" stroke-linejoin="round" stroke-width="4">
                                                <path d="M21 38c9.389 0 17-7.611 17-17S30.389 4 21 4S4 11.611 4 21s7.611 17 17 17Z" />
                                                <path stroke-linecap="round" d="M26.657 14.343A7.975 7.975 0 0 0 21 12a7.975 7.975 0 0 0-5.657 2.343m17.879 18.879l8.485 8.485" />
                                            </g>
                                        </svg>
                                        <span>Быстрый просмотр</span>
                                    </button>
                                    <button class="catalog-card__action btn-reset" type="button" data-product="10" data-create-order data-src="#create-order" onclick="console.log(this)">
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="32" height="32" preserveAspectRatio="xMidYMid meet" viewBox="0 0 32 32" style="-ms-transform: rotate(360deg); -webkit-transform: rotate(360deg); transform: rotate(360deg);">
                                            <path fill="currentColor" d="M16 3.094L7.094 12H2v6h1.25l2.781 9.281l.219.719h19.5l.219-.719L28.75 18H30v-6h-5.094zm0 2.844L22.063 12H9.938zM4 14h24v2h-.75l-.219.719L24.25 26H7.75l-2.781-9.281L4.75 16H4zm7 3v7h2v-7zm4 0v7h2v-7zm4 0v7h2v-7z"
                                            />
                                        </svg>
                                        <span>Купить</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="pagination">
                        <div class="pagination__row">
                            <a class="pagination__label" href="javascript:void(0)">Предыдущая</a>
                            <ul class="pagination__list">
                                <li class="pagination__item">
                                    <a class="pagination__link pagination__link--current" href="javascript:void(0)">
                                        <span>1</span>
                                    </a>
                                </li>
                                <li class="pagination__item">
                                    <a class="pagination__link" href="javascript:void(0)">
                                        <span>2</span>
                                    </a>
                                </li>
                                <li class="pagination__item">
                                    <a class="pagination__link" href="javascript:void(0)">
                                        <span>3</span>
                                    </a>
                                </li>
                                <li class="pagination__item">
                                    <a class="pagination__link" href="javascript:void(0)">
                                        <span>4</span>
                                    </a>
                                </li>
                            </ul>
                            <a class="pagination__label" href="javascript:void(0)">Предыдущая</a>
                        </div>
                    </div>
                </section>
            </main>
        </div>
    </div>
@endsection
