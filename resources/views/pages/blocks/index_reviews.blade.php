@if(count($index_reviews))
    <section class="section section--grey reviews">
        <div class="container container--small">
            <h2 class="section__title centered">Отзывы</h2>
            <div class="reiews__slider swiper" data-reviews-slider>
                <div class="reviews__wrapper swiper-wrapper">
                    @foreach($index_reviews as $review)
                        <div class="reviews__item swiper-slide">
                            <div class="reviews__avatar lazy" data-bg="{{ $review->thumb(1) ?: \Fanky\Admin\Models\Review::NO_IMAGE }}"></div>
                            <div class="reviews__content">
                                <div class="reviews__text">
                                    {{ $review->text }}
                                </div>
                                <div class="reviews__footer">{{ $review->name }}</div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="reviews__wrapper reviews__wrapper--nav">
                    <div class="reviews__nav">
                        <div class="reviews__prev">
                            <svg width="8" height="14" viewBox="0 0 8 14" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path d="M6.65685 1L2.41421 5.24264C1.63316 6.02369 1.63316 7.29002 2.41421 8.07107L6.65685 12.3137"
                                      stroke="black" stroke-opacity="0.5" stroke-width="2" stroke-linecap="round"/>
                            </svg>

                        </div>
                        <div class="reviews__pagination"></div>
                        <div class="reviews__next">
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
    </section>
@endif