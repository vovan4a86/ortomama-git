<div class="catalog__item">
    <div class="catalog-card">
        <a class="catalog-card__brand" href="javascript:void(0)"
           title="{{ $product->brand->name }}">{{ $product->brand->name }}</a>
        <div class="catalog-card__id">Арт.:&nbsp;
            <span>{{ $product->article }}</span>
        </div>
        <a class="catalog-card__link" href="{{ $product->url }}">
            <img class="catalog-card__picture lazy" src="/" data-src="{{ $product->image()->first()->thumb(2) }}"
                 width="330" height="200"
                 alt="{{ $product->name }}">
        </a>
        <div class="catalog-card__text">{{ $product->name }}</div>
        @if ($product->compensation)
            <a class="catalog-card__fss" href="ajax-ipr.html" data-fancybox data-type="ajax">
                <img class="lazy" src="/" data-src="/static/images/common/fss.png" width="50" height="43" alt="">
                <span>Компенсация ФСС</span>
            </a>
        @endif
        <div class="catalog-card__price">Цена от
            <span data-end="₽">{{ $product->price }}</span>
            @if ($product->old_price)
                <div class="catalog-card__oldprice" data-end="₽">{{ $product->old_price }}</div>
            @endif
        </div>
        <div class="catalog-card__overlay">
            <button class="catalog-card__action btn-reset" type="button">
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="32"
                     height="32" preserveAspectRatio="xMidYMid meet" viewBox="0 0 48 48"
                     style="-ms-transform: rotate(360deg); -webkit-transform: rotate(360deg); transform: rotate(360deg);">
                    <g fill="none" stroke="currentColor" stroke-linejoin="round" stroke-width="4">
                        <path d="M21 38c9.389 0 17-7.611 17-17S30.389 4 21 4S4 11.611 4 21s7.611 17 17 17Z"/>
                        <path stroke-linecap="round"
                              d="M26.657 14.343A7.975 7.975 0 0 0 21 12a7.975 7.975 0 0 0-5.657 2.343m17.879 18.879l8.485 8.485"/>
                    </g>
                </svg>
                <span>Быстрый просмотр</span>
            </button>
            <button class="catalog-card__action btn-reset" type="button" data-product="{{ $product->id }}" data-create-order
                    data-src="#create-order" onclick="console.log(this)">
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="32"
                     height="32" preserveAspectRatio="xMidYMid meet" viewBox="0 0 32 32"
                     style="-ms-transform: rotate(360deg); -webkit-transform: rotate(360deg); transform: rotate(360deg);">
                    <path fill="currentColor"
                          d="M16 3.094L7.094 12H2v6h1.25l2.781 9.281l.219.719h19.5l.219-.719L28.75 18H30v-6h-5.094zm0 2.844L22.063 12H9.938zM4 14h24v2h-.75l-.219.719L24.25 26H7.75l-2.781-9.281L4.75 16H4zm7 3v7h2v-7zm4 0v7h2v-7zm4 0v7h2v-7z"
                    />
                </svg>
                <span>Купить</span>
            </button>
        </div>
    </div>
</div>
