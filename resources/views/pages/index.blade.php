@extends('template')
@section('content')
    @if(count($main_slider))
        <section class="slider">
            <div class="container slider__container">
                <div class="slider__row swiper" data-main-slider>
                    <div class="slider__wrapper swiper-wrapper">
                        @foreach($main_slider as $slide)
                            <div class="slider__item swiper-slide">
                                <div class="slider__content">
                                    <h2 class="slider__title">
                                        <a href="{{ $slide['url'] }}">{{ $slide['name'] }}</a>
                                    </h2>
                                    @php
                                        $list = explode(',', $slide['feats'])
                                    @endphp
                                    @if(count($list))
                                        <ul class="slider__list">
                                            @foreach($list as $item)
                                                <li>{{ $item }}</li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </div>
                                <div class="slider__preview">
                                    <a href="{{ $slide['url'] }}" title="{{ $slide['name'] }}">
                                        @if($slide['image'])
                                            <picture>
                                                <img class="swiper-lazy" data-src="{{ S::fileSrc($slide['image']) }}"
                                                     src="{{ S::fileSrc($slide['image']) }}"
                                                     alt="{{ $slide['name'] }}" title="{{ $slide['name'] }}"/>
                                            </picture>
                                        @endif
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="slider__wrapper slider__wrapper--nav">
                        <div class="slider__nav">
                            <div class="slider__prev">
                                <svg width="8" height="14" viewBox="0 0 8 14" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path d="M6.65685 1L2.41421 5.24264C1.63316 6.02369 1.63316 7.29002 2.41421 8.07107L6.65685 12.3137"
                                          stroke="black" stroke-opacity="0.5" stroke-width="2" stroke-linecap="round"/>
                                </svg>

                            </div>
                            <div class="slider__pagination"></div>
                            <div class="slider__next">
                                <svg width="8" height="14" viewBox="0 0 8 14" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path d="M1.72058 1L5.96322 5.24264C6.74427 6.02369 6.74427 7.29002 5.96322 8.07107L1.72058 12.3137"
                                          stroke="black" stroke-opacity="0.5" stroke-width="2" stroke-linecap="round"/>
                                </svg>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @if(count($main_categories))
                <div class="slider__catalog catalog-slider">
                    <div class="catalog-slider__grid">
                        @foreach($main_categories as $cat)
                            <div class="catalog-slider__item">
                                @if($icon = $cat['icon'])
                                    <div class="catalog-slider__icon">
                                        <img class="lazy" data-src="{{ S::fileSrc($icon) }}"
                                             src="{{ S::fileSrc($icon) }}"
                                             alt="{{ $cat['name'] }}" title="{{ $cat['name'] }}"/>
                                    </div>
                                @endif
                                <span>{{ $cat['name'] }}</span>
                            </div>
                        @endforeach
                        <button class="contacts-header__action btn" type="button" data-fancybox=""
                                data-src="#create-request" aria-label="Заказать сейчас">
                            <span>Заказать сейчас</span>
                        </button>
                    </div>
                </div>
            @endif
        </section>
    @endif

    @if($main_features_chunks)
        <section class="section benefits">
        <div class="container container--small">
            <h2 class="section__title centered">Преимущества</h2>
            <div class="benefits__grid">
                @foreach($main_features_chunks as $chunk)
                    @foreach($chunk as $item)
                        <div class="benefit benefit--{{ $features_colors[$loop->index] }}">
                            @if($icon = $item['icon'])
                                <div class="benefit__icon">
                                    <img class="lazy" data-src="{{ S::fileSrc($icon) }}"
                                         src="{{ S::fileSrc($icon) }}" alt="{{ $item['name'] }}"
                                         title="{{ $item['name'] }}"/>
                                </div>
                            @endif
                            <div class="benefit__content">
                                <p>{{ $item['name'] }}</p>
                            </div>
                        </div>
                    @endforeach
                @endforeach
            </div>
        </div>
    </section>
    @endif

    @include('pages.blocks.index_reviews')

    @include('pages.blocks.index_cats')

    <section class="section mailing">
        <div class="container container--small">
            <div class="mailing__grid">
                <div class="mailing__content">
                    <h2 class="mailing__title section__title">Подпишитесь на рассылку</h2>
                    <p>Чтобы быть в курсе наших последних новостей, получать рекомендации и информацию о полезных
                        статьях</p>
                </div>
                <form class="mailing__form form" action="{{ route('ajax.subscribe') }}" data-mailing
                        onsubmit="sendSubscribe(this, event)">
                    <div class="mailing__row">
                        <input class="form__input" type="text" name="email" placeholder="Введите ваш e-mail" required>
                        <button class="form__btn btn">
                            <span>Подписаться</span>
                        </button>
                    </div>
                    <div class="err"></div>
                </form>
            </div>
        </div>
    </section>
@stop
