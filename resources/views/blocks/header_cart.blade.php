<div class="header__column header__column--basket">
    <a class="basket" href="{{ route('cart') }}" title="Перейти в корзину">
        <span class="basket__icon lazy" data-bg="/static/images/common/basket.png"></span>
        <span class="basket__label">Товаров
            <strong>{{ $count }}</strong>
        </span>
    </a>
</div>
