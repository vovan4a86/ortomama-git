@extends('template')
@section('content')
    @include('blocks.bread')
    <div class="container container--inner">
        @include('catalog.blocks.product_aside')
        <div class="container__main">
            <main>
                <section class="product">
                    <form class="product__grid" action="#">
                        <div class="product__info">
                            <div class="product__preview">
                                <a href="{{ $product->image_src }}" title="{{ $product->name }}" data-fancybox
                                   data-caption="{{ $product->name }}">
                                    <img class="lazy" data-src="{{ $product->image()->first()->thumb(3) }}"
                                         src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw=="
                                         alt="{{ $product->name }}"
                                         title="{{ $product->name }}">
                                </a>
                            </div>
                            @if(count($product->docs))
                                <div class="product__links text-content">
                                    @foreach($product->docs as $doc)
                                    <a class="download download--doc" href="{{ $doc->doc_src }}" data-fancybox data-type="ajax">
                                        {{ $doc->name }}
                                    </a>
                                    @endforeach
                                    @if ($product->compensation)
                                        <a class="product__fss" href="javascript:void(0)">
                                            <img class="lazy" data-src="/static/images/common/fss.png"
                                                 src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw=="
                                                 alt="Компенсация ФСС" title="Компенсация ФСС"/>
                                            <span>Компенсация ФСС</span>
                                        </a>
                                    @endif
                                </div>
                            @endif
                        </div>
                        <div class="product__data">
                            <h1 class="product__title">{{ $product->name }}</h1>
                            <div class="product__code">Артикул:
                                <span>{{ $product->article }}</span>
                            </div>
                            <h2 class="product__subtitle">Описание</h2>
                            <div class="product__text">
                                @if ($product->text)
                                    {!! $product->text !!}
                                @else
                                    <div>Без описания</div>
                                @endif
                            </div>
                            <div class="product__summary">
                                <div class="product__price price-product">Цена без скидки
                                    <span data-end="₽">{{ $product->price }}</span>
                                </div>
                                <div class="product__discounts">
                                    <div class="product__discount discount-product">
                                        <div class="discount-product__label">Скидка за самовывоз</div>
                                        <div class="discount-product__value" data-end="₽">-200</div>
                                    </div>
                                    <div class="product__discount discount-product">
                                        <div class="discount-product__label">Скидка по предоплате</div>
                                        <div class="discount-product__value" data-end="₽">-170</div>
                                    </div>
                                </div>
                            </div>
                            <div class="product__actions actions-product">
                                <div class="actions-product__column">
                                    <div class="actions-product__size">
                                        <span>Выбор размера</span>
                                        @if (count($sizes))
                                            <div class="radios">
                                                @foreach($sizes as $size)
                                                    <label class="radios__label">
                                                        <input class="radios__input" type="radio" name="size"
                                                               value="{{ $size->value }}">
                                                        <span class="radios__box">{{ $size->value }}</span>
                                                    </label>
                                                @endforeach
                                            </div>
                                        @else
                                            <div>Нет доступных размеров</div>
                                        @endif
                                    </div>
                                </div>
                                <div class="actions-product__column">
                                    <div class="actions-product__list">
                                        <button class="btn btn--small btn--cart" type="button" data-product="10"
                                                data-create-order data-src="#create-order" onclick="console.log(this)">
                                            <svg class="svg-sprite-icon icon-basket">
                                                <use xlink:href="static/images/sprite/symbol/sprite.svg#basket"></use>
                                            </svg>
                                            <span>В корзину</span>
                                        </button>
                                        <a class="btn btn--small btn--message" href="javascript:void(0)" target="_blank"
                                           rel="noopener">
                                            <span>Заказать по</span>
                                            <svg class="svg-sprite-icon icon-wa">
                                                <use xlink:href="static/images/sprite/symbol/sprite.svg#wa"></use>
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="sert-info">
                        <div class="sert-info__content" data-tooltip="Подсказка - всплывающая текст">
                            <img class="sert-info__picture lazy" src="/" data-src="/static/images/common/disabled.png"
                                 alt="" width="37" height="70">
                            <div class="sert-info__text">Работаем по
                                <a href="javascript:void(0)">электронным сертификатам</a>&nbsp;по индивидуальной
                                программе реабилитации
                            </div>
                        </div>
                    </div>
                    @include('catalog.blocks.points')
                    <h2 class="product__subtitle">Характеристики</h2>
                    @if (count($chars))
                        <div class="product__params">
                            @foreach($chars as $char)
                                <dl class="param">
                                    <dt class="param__key">
                                        <span>{{ $char->name }}</span>
                                    </dt>
                                    <dd class="param__value">{{ $char->value }}</dd>
                                </dl>
                            @endforeach
                        </div>
                    @else
                        <div>Не указаны</div>
                    @endif
                </section>
            </main>
        </div>
    </div>
    <!-- if productPage-->
    <section class="viewed">
        <div class="container">
            <h2 class="v-hidden">Просмотренные товары</h2>
            <div class="viewed__title">Вы смотрели (12)</div>
            <div class="viewed__container">
                <div class="viewed__slider swiper" data-viewed-slider>
                    <div class="viewed__wrapper swiper-wrapper">
                        <div class="viewed__item swiper-slide">
                            <a class="card" href="javascript:void(0)"
                               title="Ортопедические сандалии с открытым носком и высоким задником TW-176 TWIKI (р.26-30)">
									<span class="card__preview">
										<img class="swiper-lazy" data-src="/static/images/common/product-1.png"
                                             src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw=="
                                             width="200" height="200" alt="alt" title="title"/>
									</span>
                                <span class="card__title">Ортопедические сандалии с открытым носком и высоким задником TW-176 TWIKI (р.26-30)</span>
                            </a>
                        </div>
                        <div class="viewed__item swiper-slide">
                            <a class="card" href="javascript:void(0)"
                               title="Ортопедические туфли женские на шнурках черные 17-014">
									<span class="card__preview">
										<img class="swiper-lazy" data-src="/static/images/common/product-2.png"
                                             src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw=="
                                             width="200" height="200" alt="alt" title="title"/>
									</span>
                                <span class="card__title">Ортопедические туфли женские на шнурках черные 17-014</span>
                            </a>
                        </div>
                        <div class="viewed__item swiper-slide">
                            <a class="card" href="javascript:void(0)"
                               title="Ортопедические сандалии с открытым носком и высоким задником TW-176 TWIKI (р.26-30)">
									<span class="card__preview">
										<img class="swiper-lazy" data-src="/static/images/common/product-3.png"
                                             src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw=="
                                             width="200" height="200" alt="alt" title="title"/>
									</span>
                                <span class="card__title">Ортопедические сандалии с открытым носком и высоким задником TW-176 TWIKI (р.26-30)</span>
                            </a>
                        </div>
                        <div class="viewed__item swiper-slide">
                            <a class="card" href="javascript:void(0)"
                               title="Ортопедические сандалии с открытым носком и высоким задником">
									<span class="card__preview">
										<img class="swiper-lazy" data-src="/static/images/common/product-4.png"
                                             src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw=="
                                             width="200" height="200" alt="alt" title="title"/>
									</span>
                                <span class="card__title">Ортопедические сандалии с открытым носком и высоким задником</span>
                            </a>
                        </div>
                        <div class="viewed__item swiper-slide">
                            <a class="card" href="javascript:void(0)"
                               title="Ортопедические сандалии с открытым носком и высоким задником TW-176 TWIKI (р.26-30)">
									<span class="card__preview">
										<img class="swiper-lazy" data-src="/static/images/common/product-1.png"
                                             src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw=="
                                             width="200" height="200" alt="alt" title="title"/>
									</span>
                                <span class="card__title">Ортопедические сандалии с открытым носком и высоким задником TW-176 TWIKI (р.26-30)</span>
                            </a>
                        </div>
                        <div class="viewed__item swiper-slide">
                            <a class="card" href="javascript:void(0)"
                               title="Ортопедические туфли женские на шнурках черные 17-014">
									<span class="card__preview">
										<img class="swiper-lazy" data-src="/static/images/common/product-2.png"
                                             src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw=="
                                             width="200" height="200" alt="alt" title="title"/>
									</span>
                                <span class="card__title">Ортопедические туфли женские на шнурках черные 17-014</span>
                            </a>
                        </div>
                        <div class="viewed__item swiper-slide">
                            <a class="card" href="javascript:void(0)"
                               title="Ортопедические сандалии с открытым носком и высоким задником TW-176 TWIKI (р.26-30)">
									<span class="card__preview">
										<img class="swiper-lazy" data-src="/static/images/common/product-3.png"
                                             src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw=="
                                             width="200" height="200" alt="alt" title="title"/>
									</span>
                                <span class="card__title">Ортопедические сандалии с открытым носком и высоким задником TW-176 TWIKI (р.26-30)</span>
                            </a>
                        </div>
                        <div class="viewed__item swiper-slide">
                            <a class="card" href="javascript:void(0)"
                               title="Ортопедические сандалии с открытым носком и высоким задником">
									<span class="card__preview">
										<img class="swiper-lazy" data-src="/static/images/common/product-4.png"
                                             src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw=="
                                             width="200" height="200" alt="alt" title="title"/>
									</span>
                                <span class="card__title">Ортопедические сандалии с открытым носком и высоким задником</span>
                            </a>
                        </div>
                        <div class="viewed__item swiper-slide">
                            <a class="card" href="javascript:void(0)"
                               title="Ортопедические сандалии с открытым носком и высоким задником TW-176 TWIKI (р.26-30)">
									<span class="card__preview">
										<img class="swiper-lazy" data-src="/static/images/common/product-1.png"
                                             src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw=="
                                             width="200" height="200" alt="alt" title="title"/>
									</span>
                                <span class="card__title">Ортопедические сандалии с открытым носком и высоким задником TW-176 TWIKI (р.26-30)</span>
                            </a>
                        </div>
                        <div class="viewed__item swiper-slide">
                            <a class="card" href="javascript:void(0)"
                               title="Ортопедические туфли женские на шнурках черные 17-014">
									<span class="card__preview">
										<img class="swiper-lazy" data-src="/static/images/common/product-2.png"
                                             src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw=="
                                             width="200" height="200" alt="alt" title="title"/>
									</span>
                                <span class="card__title">Ортопедические туфли женские на шнурках черные 17-014</span>
                            </a>
                        </div>
                        <div class="viewed__item swiper-slide">
                            <a class="card" href="javascript:void(0)"
                               title="Ортопедические сандалии с открытым носком и высоким задником TW-176 TWIKI (р.26-30)">
									<span class="card__preview">
										<img class="swiper-lazy" data-src="/static/images/common/product-3.png"
                                             src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw=="
                                             width="200" height="200" alt="alt" title="title"/>
									</span>
                                <span class="card__title">Ортопедические сандалии с открытым носком и высоким задником TW-176 TWIKI (р.26-30)</span>
                            </a>
                        </div>
                        <div class="viewed__item swiper-slide">
                            <a class="card" href="javascript:void(0)"
                               title="Ортопедические сандалии с открытым носком и высоким задником">
									<span class="card__preview">
										<img class="swiper-lazy" data-src="/static/images/common/product-4.png"
                                             src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw=="
                                             width="200" height="200" alt="alt" title="title"/>
									</span>
                                <span class="card__title">Ортопедические сандалии с открытым носком и высоким задником</span>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="viewed__nav nav-viewed">
                    <div class="nav-viewed__prev">
                        <svg width="21" height="37" viewBox="0 0 21 37" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M18.5 2L3.41425 17.0858C2.6332 17.8668 2.6332 19.1331 3.41425 19.9142L18.5 35"
                                  stroke="#00B4AB" stroke-width="4" stroke-linecap="round"/>
                        </svg>

                    </div>
                    <div class="nav-viewed__next">
                        <svg width="21" height="37" viewBox="0 0 21 37" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M2.5 2L17.5858 17.0858C18.3668 17.8668 18.3668 19.1331 17.5858 19.9142L2.5 35"
                                  stroke="#00B4AB" stroke-width="4" stroke-linecap="round"/>
                        </svg>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
