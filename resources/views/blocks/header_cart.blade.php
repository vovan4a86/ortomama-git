<div class="header__column header__column--basket">
    <a class="basket" href="{{ route('cart') }}" title="Перейти в корзину">
        <img class="basket__icon" src="/static/images/common/basket.png">
        <span class="basket__label">Товаров
            <strong>{{ \Fanky\Admin\Cart::count() }}</strong>
        </span>
    </a>
</div>
