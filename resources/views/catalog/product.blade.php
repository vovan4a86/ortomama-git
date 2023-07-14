@extends('template')
@section('content')
    @include('blocks.bread')
    <!-- aside layout-->
    <div class="layout">
        <div class="layout__container container">
            <button class="request-btn request-btn--accent btn-reset" type="button" data-popup="data-popup" data-src="#request" aria-label="Запрос менеджеру" data-title="Запрос менеджеру">
                <span class="request-btn__icon lazy" data-bg="/static/images/common/ico_request--white.svg"></span>
                <span class="request-btn__label">Запрос менеджеру</span>
            </button>
            @include('catalog.blocks.layout_aside')
            <div class="layout__content">
                <main>
                    <section class="section">
                        <div class="section__head">{{ $product->name }}</div>
                        <form class="product" action="#">
                            <input type="hidden" name="product"
                                   value="{{ $product->name }}">
                            <div class="product__top" x-data="{ shareIsShow: false }">
                                <button class="product__share share btn-reset" type="button" aria-label="Поделиться"
                                        data-popup="" data-src="#share">
                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <g clip-path="url(#clip0_641_702)">
                                            <path d="M12.6875 10.375C11.7612 10.375 10.945 10.8307 10.4323 11.5236L5.99969 9.25387C6.07328 9.00303 6.125 8.74306 6.125 8.46875C6.125 8.09669 6.04872 7.74297 5.91694 7.41762L10.5558 4.62612C11.0721 5.232 11.8309 5.625 12.6875 5.625C14.2384 5.625 15.5 4.36341 15.5 2.8125C15.5 1.26159 14.2384 0 12.6875 0C11.1366 0 9.875 1.26159 9.875 2.8125C9.875 3.16991 9.94859 3.50894 10.0707 3.82369L5.41797 6.62337C4.90216 6.0355 4.15428 5.65625 3.3125 5.65625C1.76159 5.65625 0.5 6.91784 0.5 8.46875C0.5 10.0197 1.76159 11.2812 3.3125 11.2812C4.25406 11.2812 5.08409 10.8122 5.59484 10.0998L10.0128 12.3622C9.93147 12.6248 9.875 12.8984 9.875 13.1875C9.875 14.7384 11.1366 16 12.6875 16C14.2384 16 15.5 14.7384 15.5 13.1875C15.5 11.6366 14.2384 10.375 12.6875 10.375Z"
                                                  fill="currentColor"></path>
                                        </g>
                                        <defs>
                                            <clipPath id="clip0_641_702">
                                                <rect width="16" height="16" fill="white"></rect>
                                            </clipPath>
                                        </defs>
                                    </svg>
                                    <span>Поделиться</span>
                                </button>
                                <div class="product__code">Код товара: {{ $product->article }}</div>
                                <div class="product__sharing" x-show="shareIsShow" x-transition.duration.300ms x-cloak
                                     @click.outside="shareIsShow = false">
                                </div>
                            </div>
                            <div class="product__grid">
                                <div class="product__preview">
                                    @if($product->getRecourseDiscountAmount())
                                        <div class="product__preview-top">
                                            <div class="product__badge badge">Лучшая цена</div>
                                        </div>
                                    @endif
                                    <div class="product__preview-body">
                                        <div class="product__slider swiper" data-product-slider>
                                            @if(count($images))
                                                <div class="product__slider-wrapper swiper-wrapper">
                                                    @foreach($images as $img)
                                                        <div class="product__slider-slide swiper-slide">
                                                            <a href="{{ stripos($img->image, '/') !== false ? $img->image : \Fanky\Admin\Models\Product::UPLOAD_CUSTOM_IMG . $img->image }}"
                                                               data-fancybox="product-gallery"
                                                               title="{{ $product->name }}">
                                                                <img class="product__view"
                                                                     src="{{ stripos($img->image, '/') !== false ? $img->image : \Fanky\Admin\Models\Product::UPLOAD_CUSTOM_IMG . $img->image }}"
                                                                     width="359"
                                                                     height="239" alt="">
                                                            </a>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                        <div class="product__slider-nav swiper" data-product-slider-thumbs>
                                            @if(count($images))
                                                <div class="product__slider-nav-wrapper swiper-wrapper">
                                                    @foreach($images as $img)
                                                        <div class="product__slider-nav-slide swiper-slide">
                                                            <img class="product__view"
                                                                 src="{{ stripos($img->image, '/') !== false ? $img->image : \Fanky\Admin\Models\Product::UPLOAD_CUSTOM_IMG . $img->image }}" width="100"
                                                                 height="100" alt="">
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="product__body">
                                    <div class="p-actions">
                                        <div class="p-actions__row">
                                            @if($product->price)
                                                <div class="p-actions__col p-actions__col--price">
                                                    <div class="p-actions__label">Стоимость ед.</div>
                                                    <div class="p-actions__price">{{ $product->price }} руб.</div>
                                                </div>
                                            @endif
                                            <div class="p-actions__col p-actions__col--count">
                                                <div class="p-actions__label">Кол-во {{ $product->getRecourseMeasure() ? ',' . $product->getRecourseMeasure() : '' }}</div>
                                                <div class="p-actions__count">
                                                    <div class="counter" data-counter="data-counter">
                                                        <button class="counter__btn counter__btn--prev btn-reset"
                                                                type="button" aria-label="Меньше"
                                                                onclick="changeQuantityDown()">
                                                            <svg width="14" height="14" viewBox="0 0 14 14"
                                                                 fill="none"
                                                                 xmlns="http://www.w3.org/2000/svg">
                                                                <g clip-path="url(#clip0_657_3899)">
                                                                    <path d="M13.0454 5.73724H0.954545C0.427635 5.73724 0 6.16488 0 6.69179V7.32811C0 7.85503 0.427635 8.28266 0.954545 8.28266H13.0454C13.5723 8.28266 14 7.85503 14 7.32811V6.69179C14 6.16488 13.5723 5.73724 13.0454 5.73724Z"
                                                                          fill="#BDBDBD"/>
                                                                </g>
                                                                <defs>
                                                                    <clipPath id="clip0_657_3899">
                                                                        <rect width="14" height="14" rx="4"
                                                                              fill="white"/>
                                                                    </clipPath>
                                                                </defs>
                                                            </svg>
                                                        </button>
                                                        <input class="counter__input" type="number" name="count"
                                                               value="{{ $product->price ? 1 : 0 }}"
                                                               data-count="data-count"/>
                                                        <button class="counter__btn counter__btn--next btn-reset"
                                                                type="button" aria-label="Больше"
                                                                onclick="changeQuantityUp()">
                                                            <svg width="14" height="14" viewBox="0 0 14 14"
                                                                 fill="none"
                                                                 xmlns="http://www.w3.org/2000/svg">
                                                                <g clip-path="url(#clip0_657_3897)">
                                                                    <path d="M12.75 5.75H8.5C8.36194 5.75 8.25 5.63806 8.25 5.5V1.25C8.25 0.559692 7.69031 0 7 0C6.30969 0 5.75 0.559692 5.75 1.25V5.5C5.75 5.63806 5.63806 5.75 5.5 5.75H1.25C0.559692 5.75 0 6.30969 0 7C0 7.69031 0.559692 8.25 1.25 8.25H5.5C5.63806 8.25 5.75 8.36194 5.75 8.5V12.75C5.75 13.4403 6.30969 14 7 14C7.69031 14 8.25 13.4403 8.25 12.75V8.5C8.25 8.36194 8.36194 8.25 8.5 8.25H12.75C13.4403 8.25 14 7.69031 14 7C14 6.30969 13.4403 5.75 12.75 5.75Z"
                                                                          fill="#BDBDBD"/>
                                                                </g>
                                                                <defs>
                                                                    <clipPath id="clip0_657_3897">
                                                                        <rect width="14" height="14" rx="4"
                                                                              fill="white"/>
                                                                    </clipPath>
                                                                </defs>
                                                            </svg>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            @if($product->price)
                                                <div class="p-actions__col p-actions__col--total">
                                                    <div class="p-actions__total">Итого:&nbsp;
                                                        @if($product->price)
                                                            <span>за 1 {{ $product->getRecourseMeasure() }}</span>
                                                        @endif
                                                    </div>
                                                    <div class="p-actions__summary">{{ $product->price }} ₽</div>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="p-actions__action">
                                            <button class="p-actions__btn btn-reset" aria-label="Добавить в заказ"
                                                    data-count="{{ $product->price ? 1 : 0 }}"
                                                    onclick="addToCart(this, {{ $product->id }}, event)">
                                                <span>Добавить в заказ</span>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="p-infos" x-data="{ open: false }">
                                        @if($deliv = Settings::get('prod_delivery_info'))
                                            <div class="p-infos__item">
                                                <div class="p-infos__head"
                                                     :class="open == 'Информация о доставке' &amp;&amp; 'is-active'"
                                                     @click="open == 'Информация о доставке' ? open = false : open = 'Информация о доставке'">
                                                    <div class="p-infos__title">
                                                        <div class="p-infos__icon lazy"
                                                             data-bg="/static/images/common/ico_delivery.svg"></div>
                                                        <div class="p-infos__label">Информация о доставке</div>
                                                    </div>
                                                    <div class="p-infos__trigger lazy"
                                                         data-bg="/static/images/common/ico_dropdown.svg"></div>
                                                </div>
                                                <div class="p-infos__body" x-show="open == 'Информация о доставке'"
                                                     x-transition.duration.250ms x-cloak>
                                                    @foreach($deliv as $item)
                                                        <p>{{ $item }}</p>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif
                                        @if($pay = Settings::get('prod_pay_info'))
                                            <div class="p-infos__item">
                                                <div class="p-infos__head"
                                                     :class="open == 'Варианты оплаты' &amp;&amp; 'is-active'"
                                                     @click="open == 'Варианты оплаты' ? open = false : open = 'Варианты оплаты'">
                                                    <div class="p-infos__title">
                                                        <div class="p-infos__icon lazy"
                                                             data-bg="/static/images/common/ico_cash.svg"></div>
                                                        <div class="p-infos__label">Варианты оплаты</div>
                                                    </div>
                                                    <div class="p-infos__trigger lazy"
                                                         data-bg="/static/images/common/ico_dropdown.svg"></div>
                                                </div>
                                                <div class="p-infos__body" x-show="open == 'Варианты оплаты'"
                                                     x-transition.duration.250ms x-cloak>
                                                    @foreach($pay as $item)
                                                        <p>{{ $item }}</p>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="product__content" x-data="{ view: 'Описание' }">
                                <div class="product__nav">
                                    <div class="tabs">
                                        <div class="tabs__item" :class="view == 'Описание' &amp;&amp; 'is-active'"
                                             @click="view = 'Описание'">Описание
                                        </div>
                                        <div class="tabs__item"
                                             :class="view == 'Характеристики' &amp;&amp; 'is-active'"
                                             @click="view = 'Характеристики'">Характеристики
                                        </div>
                                    </div>
                                </div>
                                <div class="product__views">
                                    <div class="product__content" x-show="view == 'Описание'"
                                         x-transition.duration.250ms x-cloak>
                                        <div class="product__subtitle">{{ $product->name }}</div>
                                        <div class="product__grid-view">
                                            <div class="product__grid-body">
                                                {!! $text ?: $product->description !!}
                                            </div>
                                            <div class="product__grid-aside">
                                                @if(count($product->docs))
                                                    <div class="docs">
                                                        <div class="docs__title">Документы</div>
                                                        <div class="docs__list">
                                                            @foreach($product->docs as $item)
                                                                <a class="docs__item"
                                                                   href="{{ \Fanky\Admin\Models\ProductDoc::UPLOAD_URL . $item->file }}"
                                                                   title="{{ $item->name }}"
                                                                   download>
                                                            <span class="docs__icon lazy"
                                                                  data-bg="/static/images/common/ico_doc.svg"></span>
                                                                    <span class="docs__body">
																	<span class="docs__subtitle">{{ $item->name }}</span>
																	<span class="docs__size">{{ $item->getExtension() }}, {{ $item->getFileSizeAttribute() }}</span>
																</span>
                                                                </a>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                @endif
                                                @if(count($product->certificates))
                                                    <div class="docs">
                                                        <div class="docs__title">Сертификаты</div>
                                                        <div class="docs__list">
                                                            @foreach($product->certificates as $item)
                                                                <a class="docs__item"
                                                                   href="{{ \Fanky\Admin\Models\ProductCertificate::UPLOAD_URL . $item->image }}"
                                                                   title="Сертификат {{ $product->name }}"
                                                                   download>
                                                            <span class="docs__icon lazy"
                                                                  data-bg="/static/images/common/ico_doc.svg"></span>
                                                                    <span class="docs__body">
																	<span class="docs__subtitle">Сертификат {{ $loop->iteration }}</span>
																</span>
                                                                </a>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                @endif
                                                <div class="b-alert">{{ Settings::get('prod_warn') ?: '' }}</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="product__content" x-show="view == 'Характеристики'"
                                         x-transition.duration.250ms x-cloak>
                                        @if(is_object($chars) && count($chars))
                                            <div class="b-context" x-data="{ contextIsOpen: false }">
                                                <div class="b-context__list">
                                                    @foreach($chars as $i => $char)
                                                        @if($i < 5)
                                                            <dl>
                                                                <dt>{{ trim($char->name) }}</dt>
                                                                <dd>{{ trim($char->value) }}</dd>
                                                            </dl>
                                                        @else
                                                            <dl x-show="contextIsOpen" x-transition.duration.250ms
                                                                x-cloak>
                                                                <dt>{{ trim($char->name) }}</dt>
                                                                <dd>{{ trim($char->value) }}</dd>
                                                            </dl>
                                                        @endif
                                                    @endforeach
                                                </div>
                                                @if(count($chars) >= 5)
                                                    <div class="b-context__action"
                                                         @click="contextIsOpen = !contextIsOpen">
                                                        <span x-show="!contextIsOpen">Показать все характеристики</span>
                                                        <span x-show="contextIsOpen">Скрыть характеристики</span>
                                                    </div>
                                                @endif
                                            </div>
                                        @elseif($chars)
                                            <div class="b-context" x-data="{ contextIsOpen: false }">
                                                <div class="b-context__list">
                                                    {!! is_string($chars) ? $chars : '' !!}
                                                </div>
                                            </div>
                                        @else
                                            <div class="b-context__list">
                                                Не указаны
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @include('blocks.send_detail_count')
                            <div class="section">
                                <div class="section__block">
                                    <div class="section__row">
                                        <div class="section__content">
                                            <div class="text-block">
                                                @if($category->text)
                                                    <div class="section__subtitle">{{ $category->name }}</div>
                                                    {!! $category->text !!}
                                                @endif
                                            </div>
                                        </div>
                                        @include('catalog.blocks.aside_opt_price')
                                    </div>
                                </div>
                            </div>
                        </form>
                    </section>
                </main>
            </div>
        </div>

        @include('blocks.similar')

        <div class="s-calc lazy"
             data-bg="{{ Settings::fileSrc(Settings::get('complex_banner')['complex_banner_img']) ?: '/static/images/common/calc-bg.jpg' }}">
            <div class="s-calc__container container">
                <div class="s-calc__title">{{ Settings::get('complex_banner')['complex_banner_title'] ?: 'Комплексное снабжение строительных объектов' }}</div>
                <div class="s-calc__text">{{ Settings::get('complex_banner')['complex_banner_text'] ?: 'Подбор аналогов с полным соответствием характеристик товаров по проекту для
                    экономии бюджета' }}
                </div>
                <div class="s-calc__action">
                    <button class="btn btn--primary btn-reset" type="button" data-popup data-src="#calc"
                            aria-label="Сделать расчет">
                        <span>Сделать расчет</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="popup" id="share" style="display: none;">
        <div class="popup__container">
            <div class="popup__head">
                <div class="popup__title">Поделиться</div>
            </div>
            <ul class="share-list list-reset">
                <li class="share-list__item">
                    <a class="share-list__link"
                       href="https://vk.com/share.php?url={{ urlencode($product->url) }}&title={{ urlencode($product->name) }}&utm_source=share2"
                       title="Поделиться в ВКонтакте" tabindex="0" target="_blank">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                             aria-hidden="true" role="img"
                             class="iconify iconify--ion share-list__icon share-list__icon--vk" width="1em"
                             height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 512 512"
                             data-icon="ion:logo-vk">
                            <path fill="currentColor" fill-rule="evenodd"
                                  d="M484.7 132c3.56-11.28 0-19.48-15.75-19.48h-52.37c-13.21 0-19.31 7.18-22.87 14.86c0 0-26.94 65.6-64.56 108.13c-12.2 12.3-17.79 16.4-24.4 16.4c-3.56 0-8.14-4.1-8.14-15.37V131.47c0-13.32-4.06-19.47-15.25-19.47H199c-8.14 0-13.22 6.15-13.22 12.3c0 12.81 18.81 15.89 20.84 51.76V254c0 16.91-3 20-9.66 20c-17.79 0-61-66.11-86.92-141.44C105 117.64 99.88 112 86.66 112H33.79C18.54 112 16 119.17 16 126.86c0 13.84 17.79 83.53 82.86 175.77c43.21 63 104.72 96.86 160.13 96.86c33.56 0 37.62-7.69 37.62-20.5v-47.66c0-15.37 3.05-17.93 13.73-17.93c7.62 0 21.35 4.09 52.36 34.33C398.28 383.6 404.38 400 424.21 400h52.36c15.25 0 22.37-7.69 18.3-22.55c-4.57-14.86-21.86-36.38-44.23-62c-12.2-14.34-30.5-30.23-36.09-37.92c-7.62-10.25-5.59-14.35 0-23.57c-.51 0 63.55-91.22 70.15-122"></path>
                        </svg>
                        <span class="share-list__label">В ВКонтакте</span>
                    </a>
                </li>
                <li class="share-list__item">
                    <a class="share-list__link"
                       href="https://api.whatsapp.com/send?text={{ urlencode($product->name) }}%20{{ urlencode($product->url) }}&utm_source=share2"
                       title="Поделиться в Whatsapp" tabindex="0" target="_blank">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                             aria-hidden="true" role="img"
                             class="iconify iconify--ri share-list__icon share-list__icon--whatsapp" width="1em"
                             height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24"
                             data-icon="ri:whatsapp-fill">
                            <path fill="currentColor"
                                  d="m2.004 22l1.352-4.968A9.954 9.954 0 0 1 2 12C2 6.477 6.477 2 12 2s10 4.477 10 10s-4.477 10-10 10a9.954 9.954 0 0 1-5.03-1.355L2.004 22zM8.391 7.308a.961.961 0 0 0-.371.1a1.293 1.293 0 0 0-.294.228c-.12.113-.188.211-.261.306A2.729 2.729 0 0 0 6.9 9.62c.002.49.13.967.33 1.413c.409.902 1.082 1.857 1.971 2.742c.214.213.423.427.648.626a9.448 9.448 0 0 0 3.84 2.046l.569.087c.185.01.37-.004.556-.013a1.99 1.99 0 0 0 .833-.231a4.83 4.83 0 0 0 .383-.22s.043-.028.125-.09c.135-.1.218-.171.33-.288c.083-.086.155-.187.21-.302c.078-.163.156-.474.188-.733c.024-.198.017-.306.014-.373c-.004-.107-.093-.218-.19-.265l-.582-.261s-.87-.379-1.401-.621a.498.498 0 0 0-.177-.041a.482.482 0 0 0-.378.127v-.002c-.005 0-.072.057-.795.933a.35.35 0 0 1-.368.13a1.416 1.416 0 0 1-.191-.066c-.124-.052-.167-.072-.252-.109l-.005-.002a6.01 6.01 0 0 1-1.57-1c-.126-.11-.243-.23-.363-.346a6.296 6.296 0 0 1-1.02-1.268l-.059-.095a.923.923 0 0 1-.102-.205c-.038-.147.061-.265.061-.265s.243-.266.356-.41a4.38 4.38 0 0 0 .263-.373c.118-.19.155-.385.093-.536c-.28-.684-.57-1.365-.868-2.041c-.059-.134-.234-.23-.393-.249c-.054-.006-.108-.012-.162-.016a3.385 3.385 0 0 0-.403.004z"></path>
                        </svg>
                        <span class="share-list__label">В Whatsapp</span>
                    </a>
                </li>
                <li class="share-list__item">
                    <a class="share-list__link"
                       href="https://t.me/share/url?url={{ urlencode($product->url) }}&text={{ urlencode($product->name) }}&utm_source=share2"
                       title="Поделиться в Telegram" tabindex="0" target="_blank">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                             aria-hidden="true" role="img"
                             class="iconify iconify--cib share-list__icon share-list__icon--telegram" width="1em"
                             height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 32 32"
                             data-icon="cib:telegram-plane">
                            <path fill="currentColor"
                                  d="m29.919 6.163l-4.225 19.925c-.319 1.406-1.15 1.756-2.331 1.094l-6.438-4.744l-3.106 2.988c-.344.344-.631.631-1.294.631l.463-6.556L24.919 8.72c.519-.462-.113-.719-.806-.256l-14.75 9.288l-6.35-1.988c-1.381-.431-1.406-1.381.288-2.044l24.837-9.569c1.15-.431 2.156.256 1.781 2.013z"></path>
                        </svg>
                        <span class="share-list__label">В Telegram</span>
                    </a>
                </li>
                <li class="share-list__item">
                    <button class="share-list__link btn-reset" data-clipboard-text="{{ $product->url }}"
                            data-share-link="" aria-label="копировать ссылку" tabindex="0">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                             aria-hidden="true" role="img"
                             class="iconify iconify--fa6-regular share-list__icon share-list__icon--copy" width="1em"
                             height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 512 512"
                             data-icon="fa6-regular:copy">
                            <path fill="currentColor"
                                  d="M224 0c-35.3 0-64 28.7-64 64v224c0 35.3 28.7 64 64 64h224c35.3 0 64-28.7 64-64V64c0-35.3-28.7-64-64-64H224zM64 160c-35.3 0-64 28.7-64 64v224c0 35.3 28.7 64 64 64h224c35.3 0 64-28.7 64-64v-64h-48v64c0 8.8-7.2 16-16 16H64c-8.8 0-16-7.2-16-16V224c0-8.8 7.2-16 16-16h64v-48H64z"></path>
                        </svg>
                        <span class="share-list__label">Скопировать ссылку</span>
                    </button>
                </li>
            </ul>
        </div>
    </div>
@endsection
