<div class="tbl-order__row tbl-order__row--body" data-product="{{ $item['id'] }}">
    <div class="tbl-order__col tbl-order__col--pic">
        <a class="tbl-order__preview" href="{{ $item['url'] }}" title="Открыть товар">
            <img src="{{ $item['image'] }}" data-src="{{ $item['image'] }}"
                 width="40" height="40" alt="{{ $item['name'] }}">
        </a>
    </div>
    <div class="tbl-order__col tbl-order__col--name">
        <span>{{ $item['name'] }}</span>
    </div>
    <div class="tbl-order__col tbl-order__col--size">
        <span>{{ $item['size'] }}</span>
    </div>
    <div class="tbl-order__col tbl-order__col--count">
        <div class="counter" data-counter>
            <button class="counter__btn counter__btn--prev btn-reset">
                <svg width="8" height="14" viewBox="0 0 8 14" fill="none"
                     xmlns="http://www.w3.org/2000/svg">
                    <path opacity="0.4" d="M7.15685 1.34315L1.5 7L7.15685 12.6569"
                          stroke="#4A4A4A"/>
                </svg>

            </button>
            <input class="counter__input" type="number" name="count"
                   value="{{ $item['count'] }}" data-count>
            <button class="counter__btn counter__btn--next btn-reset">
                <svg width="8" height="14" viewBox="0 0 8 14" fill="none"
                     xmlns="http://www.w3.org/2000/svg">
                    <path opacity="0.4" d="M1.15687 1.34315L6.81372 7L1.15687 12.6569"
                          stroke="#4A4A4A"/>
                </svg>

            </button>
        </div>
    </div>
    @include('cart.cart_item_price')
    <div class="tbl-order__col tbl-order__col--discount">
        <span>{{ $item['discount_delivery'] + $item['discount_payment'] }}</span>
    </div>
    @include('cart.cart_item_price_total')
</div>
