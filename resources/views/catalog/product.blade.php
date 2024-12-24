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
                                <a href="{{ $product->single_image ? $product->image_src : \Fanky\Admin\Models\Product::NO_IMAGE }}"
                                   title="{{ $product->name }}" data-fancybox
                                   data-caption="{{ $product->name }}">
                                    <img class="lazy"
                                         data-src="{{ $product->single_image ? $product->single_image->thumb(3) : \Fanky\Admin\Models\Product::NO_IMAGE }}"
                                         src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw=="
                                         alt="{{ $product->name }}"
                                         title="{{ $product->name }}">
                                </a>
                            </div>
                            @if(count($product->docs) || $product->fss)
                                <div class="product__links text-content">
                                    @if(count($product->docs))
                                        @foreach($product->docs as $doc)
                                            <a class="download download--doc" href="{{ $doc->doc_src }}" data-fancybox
                                               data-type="ajax">
                                                {{ $doc->name }}
                                            </a>
                                        @endforeach
                                    @endif
                                    @if ($product->fss)
                                        <a class="product__fss" href="{{ route('fss') }}" target="_blank">
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
                            @if ($product->text)
                                <h2 class="product__subtitle">Описание</h2>
                                <div class="product__text">
                                    {!! $product->text !!}

                                </div>
                            @endif
                            <div class="product__summary">
                                <div class="product__price price-product">Цена без скидки
                                    <span data-end="₽">{{ $product->price }}</span>
                                </div>
                                <div class="product__discounts">
                                    @if($value = $product->getDiscountDelivery($product->catalog_id))
                                        <div class="product__discount discount-product">
                                            <div class="discount-product__label">Скидка за самовывоз</div>
                                            <div class="discount-product__value" data-end="₽">-{{ $value }}</div>
                                        </div>
                                    @endif
                                    @if($value = $product->getDiscountPayment($product->catalog_id))
                                        <div class="product__discount discount-product">
                                            <div class="discount-product__label">Скидка по предоплате</div>
                                            <div class="discount-product__value" data-end="₽">-{{ $value }}</div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="product__actions actions-product">
                                <div class="actions-product__column">
                                    <div class="actions-product__size">
                                        <span>Выбор размера</span>
                                        @if (count($sizeProducts))
                                            <div class="radios">
                                                @foreach($sizeProducts as $s_product)
                                                    <a href="{{$s_product->getUrl($s_product->catalog_id)}}">
{{--                                                        <label class="radios__label">--}}
                                                            <input class="radios__input" type="radio" name="size"
                                                                   value="{{ $s_product->size }}"
                                                                   {{ $product->id == $s_product->id ? 'checked' : null }}>
                                                            <span class="radios__box">{{ $s_product->size }}</span>
{{--                                                        </label>--}}
                                                    </a>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="actions-product__column">
                                    <div class="actions-product__list">

                                        @include('cart.add_to_cart_btn')

                                        @if($wa = S::get('soc_wa'))
                                            <a class="btn btn--small btn--message"
                                               href="{{ $wa . '?text=' . $product->name }}" target="_blank"
                                               rel="noopener">
                                                <span>Заказать по</span>
                                                <svg class="svg-sprite-icon icon-wa">
                                                    <use xlink:href="/static/images/sprite/symbol/sprite.svg#wa"></use>
                                                </svg>
                                            </a>
                                        @endif
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

                    @if (count($chars))
                        <h2 class="product__subtitle">Характеристики</h2>
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
                    @endif
                </section>
            </main>
        </div>
    </div>

    @include('catalog.blocks.viewed')

@endsection
