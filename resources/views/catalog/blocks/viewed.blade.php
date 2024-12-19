<!-- if productPage-->
<section class="viewed">
    <div class="container">
        <h2 class="v-hidden">Просмотренные товары</h2>
        <div class="viewed__title">Вы смотрели ({{ count($viewed_products) }})</div>
        <div class="viewed__container">
            <div class="viewed__slider swiper" data-viewed-slider>
                <div class="viewed__wrapper swiper-wrapper">
                    @foreach($viewed_products as $item)
                        <div class="viewed__item swiper-slide">
                        <a class="card" href="{{ $item->url }}"
                           title="{{ $item->name }}">
									<span class="card__preview">
										<img class="swiper-lazy" data-src="{{ $item->single_image->thumb(2) }}"
                                             src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw=="
                                             width="200" height="200" alt="{{ $item->name }}" title="{{ $item->name }}"/>
									</span>
                            <span class="card__title">{{ $item->name }}</span>
                        </a>
                    </div>
                    @endforeach
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
